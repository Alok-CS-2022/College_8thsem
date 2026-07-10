<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Enter Test Results — {{ $appointment->patient->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route("test-results.store", $appointment->id) }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CBC</label>
                            <input type="text" name="cbc" value="{{ old("cbc", $appointment->testResult->cbc ?? "Normal") }}" class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">HBsAg</label>
                            <input type="text" name="hbsag" value="{{ old("hbsag", $appointment->testResult->hbsag ?? "Negative") }}" class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">VDRL</label>
                            <input type="text" name="vdrl" value="{{ old("vdrl", $appointment->testResult->vdrl ?? "Negative") }}" class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">HIV</label>
                            <input type="text" name="hiv" value="{{ old("hiv", $appointment->testResult->hiv ?? "Negative") }}" class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Blood Group</label>
                            <input type="text" name="blood_group" value="{{ old("blood_group", $appointment->testResult->blood_group ?? "") }}" class="mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Urine Test</label>
                            <input type="text" name="urine_test" value="{{ old("urine_test", $appointment->testResult->urine_test ?? "Normal") }}" class="mt-1 block w-full rounded border-gray-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">X-Ray Findings</label>
                        <input type="text" name="xray_findings" value="{{ old("xray_findings", $appointment->testResult->xray_findings ?? "Clear") }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="flagged_abnormal" value="1" id="flagged" class="rounded border-gray-300" {{ ($appointment->testResult->flagged_abnormal ?? false) ? "checked" : "" }}>
                        <label for="flagged" class="ml-2 text-sm text-gray-700">Flag for further examination (abnormal result)</label>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Save Results & Mark Complete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
