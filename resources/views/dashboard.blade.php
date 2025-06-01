@extends('layouts.dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon students">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">932</div>
            <div class="stat-label">Students</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teachers">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">754</div>
            <div class="stat-label">Teachers</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon courses">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">40</div>
            <div class="stat-label">Courses</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon feedback">
            <i class="fas fa-comments"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">32</div>
            <div class="stat-label">Feedback</div>
        </div>
    </div>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">Teachers</h2>
        <a href="{{ url('/teachers') }}" class="btn btn-link">See all</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Achraf aboukir</td>
                <td>Aboukrachraf@gmail.com</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Achraf aboukir</td>
                <td>Aboukrachraf@gmail.com</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Achraf aboukir</td>
                <td>Aboukrachraf@gmail.com</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Achraf aboukir</td>
                <td>Aboukrachraf@gmail.com</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Achraf aboukir</td>
                <td>Aboukrachraf@gmail.com</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">Courses</h2>
        <a href="{{ url('/courses') }}" class="btn btn-link">See all</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Course 1</td>
                <td>Achraf Aboukir</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Course 2</td>
                <td>Achraf Aboukir</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Course 4</td>
                <td>Achraf Aboukir</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Course 5</td>
                <td>Achraf Aboukir</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Course 6</td>
                <td>Achraf Aboukir</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">Recent Feedbacks</h2>
        <a href="{{ url('/feedbacks') }}" class="btn btn-link">See all</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Teacher</th>
                <th>Group</th>
                <th>Course</th>
                <th>Content</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Achraf aboukir (kiddan)</td>
                <td>Mohamed hamdoun</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>We need more exemples</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Ibrahim touhami (chowen)</td>
                <td>Yassir amrani</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>Teacher can you please ad...</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Asmaa toungh (kiddan)</td>
                <td>Tarik targam</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>Can you slow down</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Achraf aboukir (kiddan)</td>
                <td>Mohamed hamdoun</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>Teacher you missed the pa...</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Achraf aboukir (kiddan)</td>
                <td>Mohamed hamdoun</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>We need more exemples</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection