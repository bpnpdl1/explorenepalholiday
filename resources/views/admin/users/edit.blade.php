<x-admin-layouts::app :title="__('Edit user')">
    @include('admin.users.partials.form-page-heading', ['heading' => 'Edit user'])

    @include('admin.users.partials.form', [
        'user' => $user,
        'action' => route('admin.users.update', $user),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
