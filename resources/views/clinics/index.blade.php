<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clinic Management</h2>
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
                        <th>Registration No.</th>
                        <th>License Expiry</th>
                        <th>Status</th>
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clinics as $clinic)
                        <tr class="border-b">
                            <td class="py-2">{{ $clinic->name }}</td>
                            <td>{{ $clinic->registration_number }}</td>
                            <td>{{ $clinic->license_expiry_date->format('Y-m-d') }}</td>
                            <td>
                                <span @class([
                                    'px-2 py-1 rounded text-xs',
                                    'bg-yellow-100 text-yellow-800' => in_array($clinic->status, ['submitted', 'under_review']),
                                    'bg-green-100 text-green-800' => in_array($clinic->status, ['approved', 'active']),
                                    'bg-red-100 text-red-800' => in_array($clinic->status, ['suspended', 'revoked']),
                                ])>
                                    {{ str_replace('_', ' ', $clinic->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('clinics.status', $clinic) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="border rounded text-xs">
                                        @foreach (['submitted', 'under_review', 'approved', 'active', 'suspended', 'revoked'] as $status)
                                            <option value="{{ $status }}" @selected($clinic->status === $status)>{{ str_replace('_', ' ', $status) }}</option>
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
