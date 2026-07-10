<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Doctor Review & Certificates</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session("success"))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session("success") }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Pending Doctor Review</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Patient</th>
                            <th class="px-4 py-2 text-left">Blood Group</th>
                            <th class="px-4 py-2 text-left">HIV</th>
                            <th class="px-4 py-2 text-left">X-Ray</th>
                            <th class="px-4 py-2 text-left">Flagged</th>
                            <th class="px-4 py-2 text-left">Decision</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pendingReview as $result)
                            <tr>
                                <td class="px-4 py-2">{{ $result->patient->full_name }}</td>
                                <td class="px-4 py-2">{{ $result->blood_group }}</td>
                                <td class="px-4 py-2">{{ $result->hiv }}</td>
                                <td class="px-4 py-2">{{ $result->xray_findings }}</td>
                                <td class="px-4 py-2">
                                    @if ($result->flagged_abnormal)
                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Flagged</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Normal</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <form method="POST" action="{{ route("certificates.store", $result->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="fit">
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Approve (Fit)</button>
                                    </form>
                                    <form method="POST" action="{{ route("certificates.store", $result->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="unfit">
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">Reject (Unfit)</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-gray-500">No results awaiting review.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Issued Certificates</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Patient</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Issue Date</th>
                            <th class="px-4 py-2 text-left">Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($certificates as $cert)
                            <tr>
                                <td class="px-4 py-2">{{ $cert->patient->full_name }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded {{ $cert->status === "fit" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}">
                                        {{ ucfirst($cert->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $cert->issue_date }}</td>
                                <td class="px-4 py-2">{{ $cert->expiry_date }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-4 text-gray-500">No certificates issued yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
