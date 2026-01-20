<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hazard Registration
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('hazards.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="date_registered" value="Date Register" />
                        <x-text-input id="date_registered" name="date_registered" type="date" class="mt-1 block w-full" value="{{ old('date_registered', now()->toDateString()) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('date_registered')" />
                    </div>

                    <div>
                        <x-input-label for="unit_id" value="Location / Unit Involved" />
                        <select id="unit_id" name="unit_id" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="">-- Select Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                    {{ $unit->designator }} - {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('unit_id')" />
                    </div>

                    <div>
                        <x-input-label for="fir" value="Flight Information Region (FIR)" />
                        <select id="fir" name="fir" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Select FIR --</option>
                            @foreach($firs as $fir)
                                <option value="{{ $fir }}" @selected(old('fir') == $fir)>{{ $fir }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('fir')" />
                    </div>

                    <div>
                        <x-input-label for="source_id" value="Hazard Identification Source" />
                        <select id="source_id" name="source_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Select Source --</option>
                            @foreach($sources as $s)
                                <option value="{{ $s->id }}" @selected(old('source_id') == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('source_id')" />
                    </div>

                    <div>
                        <x-input-label for="scope_id" value="Scope" />
                        <select id="scope_id" name="scope_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Select Scope --</option>
                            @foreach($scopes as $s)
                                <option value="{{ $s->id }}" @selected(old('scope_id') == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('scope_id')" />
                    </div>

                    <div>
                        <x-input-label for="generic_hazard" value="Generic Hazard/Threat (Original Report)" />
                        <textarea id="generic_hazard" name="generic_hazard" class="mt-1 block w-full border-gray-300 rounded-md" rows="3" required>{{ old('generic_hazard') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('generic_hazard')" />
                    </div>

                    <div>
                        <x-input-label for="specific_hazard" value="Specific Hazard/Threat" />
                        <textarea id="specific_hazard" name="specific_hazard" class="mt-1 block w-full border-gray-300 rounded-md" rows="3" required>{{ old('specific_hazard') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('specific_hazard')" />
                    </div>

                    <div>
                        <x-input-label for="occurrence_date" value="Occurrence Date" />
                        <x-text-input id="occurrence_date" name="occurrence_date" type="date" class="mt-1 block w-full" value="{{ old('occurrence_date') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('occurrence_date')" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description (Unsafe-Event)" />
                        <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md" rows="4" required>{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="consequence" value="Consequence / Risk" />
                        <textarea id="consequence" name="consequence" class="mt-1 block w-full border-gray-300 rounded-md" rows="3" required>{{ old('consequence') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('consequence')" />
                    </div>

                    <div>
                        <x-input-label for="initial_probability_id" value="Initial Hazard Rating" />
                        <select id="initial_probability_id" name="initial_probability_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Select Probability --</option>
                            @foreach($probability as $r)
                                <option value="{{ $r->id }}" @selected(old('initial_probability_id') == $r->id)>{{ $r->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('initial_probability_id')" />
                        <x-input-label for="initial_severity_id" value="Initial Risk Rating" />
                        <select id="initial_severity_id" name="initial_severity_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                            <option value="">-- Select Severity --</option>
                            @foreach($severity as $r)
                                <option value="{{ $r->id }}" @selected(old('initial_severity_id') == $r->id)>{{ $r->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('initial_severity_id')" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Submit Hazard</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>