<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <title>Registration Students</title>
</head>
<body>
     <div class="container no_sidebars">
        <div class="main_content">
            <div class="main_navbar">
                <div class="search_box">
                    <i class='bx bx-search-alt-2'></i> <input type="text " placeholder="Search">
                </div>
                <div class="dark_mode_icon" onclick="darkMode()">
                    <i class='bx bx-moon'></i>
                    <i class='bx bx-sun'></i>
                </div>
            </div>
            <div class="menu_item_name_and_filter ">
                <div class="menu_item_name">
                    <h2>Database</h2>
                </div>
                <div class="filter_and_sort">
                    <div class="sort sort_and_filter">
                        <p>Sort</p>
                        <i class='bx bx-sort-down'></i>
                    </div>
                    <div class="filter sort_and_filter">
                        <p>Filter</p>
                        <i class='bx bx-filter'></i>
                    </div>
                </div>
            </div>
            <div class="tabs">
                <div class="tab_name">
                    <p>Student</p>
                    <p>Teacher</p>
                    <p>Staff</p>
                </div>
                <div class="three_dots">
                    <i class='bx bx-dots-vertical-rounded'></i>
                </div>
            </div>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>College</th>
                            <th>Department</th>
                            <th>Stage</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Parallel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td class="profile_name">
                                    <img src="https://i.postimg.cc/BvPJ7FHN/img1.jpg" alt="img">
                                    {{ $student->name }}
                                </td>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->college }}</td>
                                <td>{{ $student->department }}</td>
                                <td>{{ $student->stage }}</td>
                                <td>{{ $student->gender ?? 'not specified' }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone_number }}</td>
                                <td>{{ $student->parallel ? 'Yes' : 'No' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        ...existing code...
