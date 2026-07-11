<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded p-4">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="py-2">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->name ?? 'None' }}</td>
                            <td>
                                <span @class([
                                    'px-2 py-1 rounded text-xs',
                                    'bg-green-100 text-green-800' => $user->status === 'active',
                                    'bg-yellow-100 text-yellow-800' => $user->status === 'pending',
                                    'bg-red-100 text-red-800' => in_array($user->status, ['suspended', 'blocked']),
                                ])>
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('users.status', $user) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="border rounded text-xs">
                                        @foreach (['pending', 'active', 'suspended', 'blocked'] as $status)
                                            <option value="{{ $status }}" @selected($user->status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="text-xs bg-gray-800 text-white px-2 py-1 rounded">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
