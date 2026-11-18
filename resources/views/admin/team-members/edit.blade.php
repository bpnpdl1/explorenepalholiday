<x-admin-layouts::app :title="__('Edit team member')">
    @include('admin.team-members.partials.form-page-heading', ['heading' => 'Edit team member'])

    @include('admin.team-members.partials.form', [
        'teamMember' => $teamMember,
        'action' => route('admin.team-members.update', $teamMember),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
