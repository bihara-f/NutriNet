@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="middle">
    <div class="box" style="width: 100%; text-align: center;">
        <h2>Edit FAQ</h2>
    </div>
</div>

<div class="bottom">
    <div class="form-container">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf
            @method('PUT')
            
            <label for="question">Question:</label>
            <textarea id="question" name="question" rows="3" required placeholder="Enter the frequently asked question...">{{ old('question', $faq->question) }}</textarea>
            
            <label for="answer">Answer:</label>
            <textarea id="answer" name="answer" rows="5" required placeholder="Enter the answer to the question...">{{ old('answer', $faq->answer) }}</textarea>
            
            <div class="form-btn">
                <a href="{{ route('admin.faqs') }}" class="btn" style="background-color: var(--gray); color: white; text-decoration: none;">Cancel</a>
                <button type="submit" class="btn btn-primary">Update FAQ</button>
            </div>
        </form>
    </div>
</div>
@endsection