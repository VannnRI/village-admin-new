@extends('layouts.app')

@section('title', 'Ajukan Surat')

@section('sidebar')
    @include('masyarakat.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:p-8 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-green-700 mb-8 flex items-center">
        <i class="fas fa-envelope-open mr-3"></i> Ajukan Permohonan Surat
    </h2>
    <form action="{{ route('masyarakat.letters.submit') }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="letter_type_id" class="block font-semibold text-gray-700 mb-2">Pilih Jenis Surat <span class="text-red-500">*</span></label>
            <select name="letter_type_id" id="letter_type_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required onchange="this.form.submit()">
                <option value="">-- Silakan Pilih Jenis Surat --</option>
                @foreach($letterTypes as $type)
                    <option value="{{ $type->id }}" {{ (isset($selectedTypeId) && $selectedTypeId == $type->id) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(isset($selectedTypeId) && $selectedTypeId)
    <form action="{{ route('masyarakat.letters.submit') }}" method="POST">
        @csrf
        <input type="hidden" name="letter_type_id" value="{{ $selectedTypeId }}">
        
        @if(isset($fields) && $fields->count())
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                <h4 class="font-semibold text-green-700 mb-4 flex items-center"><i class="fas fa-list-alt mr-2"></i> Lengkapi Data Berikut</h4>
                @foreach($fields as $field)
                    @php
                        $isCitizenField = in_array($field->field_name, $citizenFields) && !empty($citizen->{$field->field_name});
                    @endphp
                    @if($isCitizenField)
                        <input type="hidden" name="fields[{{ $field->field_name }}]" value="{{ $field->field_name == 'birth_date' ? ($citizen->birth_date ? $citizen->birth_date->format('Y-m-d') : '') : $citizen->{$field->field_name} }}">
                    @else
                    <div class="mb-5">
                        <label for="field_{{ $field->field_name }}" class="block font-medium text-gray-800 mb-1">{{ $field->field_label }}@if($field->is_required) <span class="text-red-500">*</span>@endif</label>
                        @if($field->field_type == 'textarea')
                            <textarea name="fields[{{ $field->field_name }}]" id="field_{{ $field->field_name }}" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" {{ $field->is_required ? 'required' : '' }}></textarea>
                        @elseif($field->field_type == 'select' || $field->field_type == 'radio' || $field->field_type == 'checkbox')
                            @php
                                $options = preg_split('/\r\n|\r|\n/', $field->field_options);
                            @endphp
                            @if($field->field_type == 'select')
                                <select name="fields[{{ $field->field_name }}]" id="field_{{ $field->field_name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" {{ $field->is_required ? 'required' : '' }}>
                                    <option value="">-- Pilih {{ $field->field_label }} --</option>
                                    @foreach($options as $option)
                                        @if(trim($option)) <option value="{{ trim($option) }}">{{ trim($option) }}</option> @endif
                                    @endforeach
                                </select>
                            @elseif($field->field_type == 'radio')
                                <div class="mt-2">
                                @foreach($options as $option)
                                    @if(trim($option))
                                    <label class="inline-flex items-center mr-4">
                                        <input type="radio" name="fields[{{ $field->field_name }}]" value="{{ trim($option) }}" class="form-radio text-green-600" {{ $field->is_required ? 'required' : '' }}>
                                        <span class="ml-2">{{ trim($option) }}</span>
                                    </label>
                                    @endif
                                @endforeach
                                </div>
                            @elseif($field->field_type == 'checkbox')
                                <div class="mt-2">
                                @foreach($options as $option)
                                    @if(trim($option))
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="fields[{{ $field->field_name }}][]" value="{{ trim($option) }}" class="form-checkbox text-green-600">
                                        <span class="ml-2">{{ trim($option) }}</span>
                                    </label>
                                    @endif
                                @endforeach
                                </div>
                            @endif
                        @else
                            <input type="{{ $field->field_type }}" name="fields[{{ $field->field_name }}]" id="field_{{ $field->field_name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" {{ $field->is_required ? 'required' : '' }}>
                        @endif
                    </div>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="mb-8">
            <label for="purpose" class="block font-semibold text-gray-700 mb-2">Tujuan Permohonan <span class="text-red-500">*</span></label>
            <textarea name="purpose" id="purpose" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required placeholder="Jelaskan tujuan dan keperluan surat ini..."></textarea>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 sm:space-x-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-200 flex items-center justify-center font-semibold shadow">
                <i class="fas fa-paper-plane mr-2"></i>
                Ajukan Surat
            </button>
            <a href="{{ route('masyarakat.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200 font-semibold shadow text-center">
                Kembali
            </a>
        </div>
    </form>
    @endif
</div>
<script>
document.getElementById('letter_type_id').addEventListener('change', function() {
    var letterTypeId = this.value;
    if (letterTypeId) {
        // Create a form to submit the selection
        var form = document.createElement('form');
        form.method = 'GET';
        form.action = '{{ route("masyarakat.letter-form") }}';
        
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'letter_type_id';
        input.value = letterTypeId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    } else {
        window.location.href = '{{ route("masyarakat.letter-form") }}';
    }
});
</script>
@endsection 