<x-admin-layouts::app :title="__('Add team member')">
    @include('admin.team-members.partials.form-page-heading', ['heading' => 'Add team member'])

    @include('admin.team-members.partials.form', [
        'teamMember' => $teamMember,
        'action' => route('admin.team-members.store'),
        'method' => 'POST',
        'submitLabel' => 'Create team member',
    ])
</x-admin-layouts::app>
