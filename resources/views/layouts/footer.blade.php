<footer class="bg-white shadow mt-auto py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Schoolar') }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-end">
                <nav>
                    <a href="{{ url('/about-us') }}" class="text-decoration-none text-muted me-3">About Us</a>
                    <a href="{{ url('/contact-us') }}" class="text-decoration-none text-muted me-3">Contact</a>
                    <a href="{{ url('/privacy-policy') }}" class="text-decoration-none text-muted">Privacy Policy</a>
                </nav>
            </div>
        </div>
    </div>
</footer> 