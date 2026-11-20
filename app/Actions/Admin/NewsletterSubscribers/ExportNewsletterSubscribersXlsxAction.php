<?php

namespace App\Actions\Admin\NewsletterSubscribers;

use Illuminate\Database\Eloquent\Builder;
use RuntimeException;
use XMLWriter;
use ZipArchive;

class ExportNewsletterSubscribersXlsxAction
{
    public function handle(Builder $subscribers): string
    {
        $worksheetPath = tempnam(sys_get_temp_dir(), 'newsletter-sheet-');
        $spreadsheetPath = tempnam(sys_get_temp_dir(), 'newsletter-export-');

        if ($worksheetPath === false || $spreadsheetPath === false) {
            if (is_string($worksheetPath)) {
                @unlink($worksheetPath);
            }

            if (is_string($spreadsheetPath)) {
                @unlink($spreadsheetPath);
            }

            throw new RuntimeException('Unable to create the newsletter export file.');
        }

        try {
            $this->writeWorksheet($worksheetPath, $subscribers);
            $this->writeSpreadsheet($spreadsheetPath, $worksheetPath);

            return $spreadsheetPath;
        } catch (\Throwable $exception) {
            @unlink($spreadsheetPath);
            throw $exception;
        } finally {
            @unlink($worksheetPath);
        }
    }

    private function writeWorksheet(string $path, Builder $subscribers): void
    {
        $writer = new XMLWriter;

        if (! $writer->openUri($path)) {
            throw new RuntimeException('Unable to write the newsletter export worksheet.');
        }

        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('worksheet');
        $writer->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $writer->startElement('sheetData');

        $rowNumber = 1;
        $this->writeRow($writer, $rowNumber, [
            'Email address',
            'Status',
            'Consent recorded',
            'Last subscribed',
            'Unsubscribed at',
        ]);

        foreach ($subscribers->orderBy('email')->cursor() as $subscriber) {
            $rowNumber++;
            $this->writeRow($writer, $rowNumber, [
                $subscriber->email,
                $subscriber->status->label(),
                $subscriber->consented_at?->format('Y-m-d H:i:s') ?? '',
                $subscriber->subscribed_at?->format('Y-m-d H:i:s') ?? '',
                $subscriber->unsubscribed_at?->format('Y-m-d H:i:s') ?? '',
            ]);
        }

        $writer->endElement();
        $writer->endElement();
        $writer->endDocument();
        $writer->flush();
    }

    /** @param array<int, string> $values */
    private function writeRow(XMLWriter $writer, int $rowNumber, array $values): void
    {
        $writer->startElement('row');
        $writer->writeAttribute('r', (string) $rowNumber);

        foreach ($values as $index => $value) {
            $column = chr(ord('A') + $index);
            $writer->startElement('c');
            $writer->writeAttribute('r', $column.$rowNumber);
            $writer->writeAttribute('t', 'inlineStr');
            $writer->startElement('is');
            $writer->writeElement('t', $value);
            $writer->endElement();
            $writer->endElement();
        }

        $writer->endElement();
    }

    private function writeSpreadsheet(string $path, string $worksheetPath): void
    {
        $archive = new ZipArchive;

        if ($archive->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Unable to package the newsletter export spreadsheet.');
        }

        $files = [
            '[Content_Types].xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
                .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
                .'<Default Extension="xml" ContentType="application/xml"/>'
                .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
                .'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
                .'</Types>',
            '_rels/.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
                .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
                .'</Relationships>',
            'xl/workbook.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
                .'<sheets><sheet name="Subscribers" sheetId="1" r:id="rId1"/></sheets>'
                .'</workbook>',
            'xl/_rels/workbook.xml.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
                .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
                .'</Relationships>',
        ];

        foreach ($files as $fileName => $contents) {
            if (! $archive->addFromString($fileName, $contents)) {
                $archive->close();
                throw new RuntimeException('Unable to write the newsletter export spreadsheet.');
            }
        }

        if (! $archive->addFile($worksheetPath, 'xl/worksheets/sheet1.xml')) {
            $archive->close();
            throw new RuntimeException('Unable to add the newsletter export worksheet.');
        }

        $archive->close();
    }
}
