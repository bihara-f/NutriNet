@extends('layouts.admin')

@section('title', 'Add New FAQ')

@section('content')
<div class="middle">
    <div class="box" style="width: 100%; text-align: center;">
        <h2>Add New FAQ</h2>
    </div>
</div>

<div class="bottom">
    <div class="form-container">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf
            
            <label for="question">Question:</label>
            <textarea id="question" name="question" rows="3" required placeholder="Enter the frequently asked question...">{{ old('question') }}</textarea>
            
            <label for="answer">Answer:</label>
            <textarea id="answer" name="answer" rows="5" required placeholder="Enter the answer to the question...">{{ old('answer') }}</textarea>
            
            <div class="form-btn">
                <a href="{{ route('admin.faqs') }}" class="btn" style="background-color: var(--gray); color: white; text-decoration: none;">Cancel</a>
                <button type="submit" class="btn btn-primary">Create FAQ</button>
            </div>
        </form>
    </div>
</div>
@endsection