@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="display-4 mb-4">Privacy Policy</h1>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="lead mb-4">
                        At {{ config('app.name', 'Schoolar') }}, we take your privacy seriously. This policy describes how we collect, use, and protect your personal information.
                    </p>

                    <h2 class="h4 mb-3">Information We Collect</h2>
                    <p class="mb-4">
                        We collect information that you provide directly to us, including:
                    </p>
                    <ul class="mb-4">
                        <li>Name and contact information</li>
                        <li>Account credentials</li>
                        <li>Educational history and progress</li>
                        <li>Course participation and completion data</li>
                        <li>Communications with us</li>
                    </ul>

                    <h2 class="h4 mb-3">How We Use Your Information</h2>
                    <p class="mb-4">
                        We use the information we collect to:
                    </p>
                    <ul class="mb-4">
                        <li>Provide and improve our educational services</li>
                        <li>Personalize your learning experience</li>
                        <li>Communicate with you about your courses</li>
                        <li>Monitor and analyze usage patterns</li>
                        <li>Protect against unauthorized access</li>
                    </ul>

                    <h2 class="h4 mb-3">Information Sharing</h2>
                    <p class="mb-4">
                        We do not sell or rent your personal information to third parties. We may share your information with:
                    </p>
                    <ul class="mb-4">
                        <li>Course instructors and administrators</li>
                        <li>Service providers who assist in our operations</li>
                        <li>Law enforcement when required by law</li>
                    </ul>

                    <h2 class="h4 mb-3">Data Security</h2>
                    <p class="mb-4">
                        We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.
                    </p>

                    <h2 class="h4 mb-3">Your Rights</h2>
                    <p class="mb-4">
                        You have the right to:
                    </p>
                    <ul class="mb-4">
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Opt-out of marketing communications</li>
                    </ul>

                    <h2 class="h4 mb-3">Contact Us</h2>
                    <p class="mb-4">
                        If you have questions about this privacy policy or our practices, please contact us at:
                    </p>
                    <p class="mb-0">
                        Email: privacy@schoolar.com<br>
                        Phone: +1 (555) 123-4567<br>
                        Address: 123 Education Street, Learning City, ED 12345
                    </p>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted">Last updated: {{ date('F Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 