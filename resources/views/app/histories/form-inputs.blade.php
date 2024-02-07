@php $editing = isset($history) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.textarea name="prompt" label="Prompt" maxlength="255" required
            >{{ old('prompt', ($editing ? $history->prompt : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="json" label="Json" maxlength="255" required
            >{{ old('json', ($editing ? $history->json : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="topic_id" label="Topic" required>
            @php $selected = old('topic_id', ($editing ? $history->topic_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Topic</option>
            @foreach($topics as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="section_id" label="Section" required>
            @php $selected = old('section_id', ($editing ? $history->section_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Section</option>
            @foreach($sections as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="course_id" label="Course" required>
            @php $selected = old('course_id', ($editing ? $history->course_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Course</option>
            @foreach($courses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $history->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
