<x-admin-layouts::app :title="__('Add user')">
    @include('admin.users.partials.form-page-heading', ['heading' => 'Add user'])

    @include('admin.users.partials.form', [
        'user' => $user,
        'action' => route('admin.users.store'),
        'method' => 'POST',
        'submitLabel' => 'Create user',
    ])
</x-admin-layouts::app>
