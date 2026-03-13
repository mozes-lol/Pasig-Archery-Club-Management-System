@extends('layouts.app')

@section('title', 'Create Training Log')
@section('page-title', 'Create Training Log')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/member-history.css">
<style>
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 6px;
    }

    .rating-input input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .rating-input label {
        font-size: 24px;
        color: #cbd5e1;
        cursor: pointer;
        transition: color 0.15s ease-in-out, transform 0.15s ease-in-out;
    }

    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #fbbf24;
        transform: translateY(-1px);
    }

    .rating-input input:checked ~ label {
        color: #f59e0b;
    }

    .rating-hint {
        margin-top: 6px;
        font-size: 12px;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h2>New Training Log</h2>
    </div>
    <form method="POST" action="{{ route('member.training-logs.store') }}" class="card-body">
        @csrf

        <div class="form-group">
            <label>Coach</label>
            <select name="coach_id" class="form-input" required>
                <option value="">Select coach...</option>
                @foreach ($coaches as $coach)
                    <option value="{{ $coach->coach_id }}">{{ $coach->first_name }} {{ $coach->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="session_date" class="form-input" required>
            </div>
            <div class="form-group">
                <label>Distance (m)</label>
                <input type="number" name="distance" class="form-input" min="1" max="2147483647">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Arrow Count</label>
                <input type="number" name="arrow_count" class="form-input" min="1" max="2147483647">
            </div>
            <div class="form-group">
                <label>Total Score</label>
                <input type="number" name="total_score" class="form-input" min="0" max="2147483647">
            </div>
        </div>

        <div class="form-group">
            <label>Coach Rating</label>
            <div class="rating-input" aria-label="Coach rating from 1 to 5">
                <input type="radio" id="rating-5" name="coach_rating" value="5">
                <label for="rating-5" title="5 - Excellent">★</label>
                <input type="radio" id="rating-4" name="coach_rating" value="4">
                <label for="rating-4" title="4 - Very Good">★</label>
                <input type="radio" id="rating-3" name="coach_rating" value="3">
                <label for="rating-3" title="3 - Good">★</label>
                <input type="radio" id="rating-2" name="coach_rating" value="2">
                <label for="rating-2" title="2 - Fair">★</label>
                <input type="radio" id="rating-1" name="coach_rating" value="1">
                <label for="rating-1" title="1 - Poor">★</label>
            </div>
            <div class="rating-hint">Click a star to rate (optional).</div>
        </div>

        <div class="form-group">
            <label>Technical Notes</label>
            <input type="text" name="technical_notes" class="form-input">
        </div>

        <button type="submit" class="btn btn-primary">Create Log</button>
    </form>
</div>
@endsection
