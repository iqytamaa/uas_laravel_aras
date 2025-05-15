@extends('layouts.user')
@section('title', 'Evaluasi Alternatif vs Kriteria')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Evaluasi Alternatif vs Kriteria</h1>

        <form action="{{ route('user.evaluation.submit') }}" method="POST">
            @csrf
            <table class="w-full table-auto border-collapse mb-4">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Alternatif</th>
                        @foreach($criterias as $crit)
                            <th class="border px-4 py-2">{{ $crit->criteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($alternatives as $alt)
                        <tr class="even:bg-gray-100">
                            <td class="border px-4 py-2">{{ $alt->name }}</td>
                            @foreach($criterias as $crit)
                                @php
                                    $ev = $evaluations
                                        ->where('id_alternative', $alt->id_alternative)
                                        ->where('id_criteria', $crit->id_criteria)
                                        ->first();
                                @endphp
                                <td class="border px-4 py-2">
                                    <input type="number" name="evaluations[{{ $alt->id_alternative }}][{{ $crit->id_criteria }}]"
                                        value="{{ $ev?->value ?? '' }}" required class="w-20 p-1 border rounded text-center" />
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Submit Evaluasi
            </button>
        </form>
    </div>
@endsection