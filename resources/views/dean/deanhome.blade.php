<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <title>Dean Dashboard</title>
    <style>
        .logout_form { display: contents; }
        .logout_btn {
            all: unset;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left_sidebar">
            <div class="close_hamburger_btn">
                <i class='bx bx-x-circle'></i>
            </div>
            <div class="logo">
                <h2 onclick="myFunction()">School</h2>
            </div>
            <div class="menu_items">
                <div class="menu_item">
                    <i class='bx bxs-dashboard'></i>
                    <p>Dashboard</p>
                </div>
                <div class="menu_item">
                    <i class='bx bx-message-rounded-dots'></i>
                    <p>Messenger</p>
                    <i class="fa-regular fa-circle-2"></i>
                </div>
                <div class="menu_item">
                    <i class='bx bx-calendar'></i>
                    <p>Calender</p>
                </div>
                <div class="menu_item">
                    <i class='bx bx-file-blank'></i>
                    <p>Database</p>
                </div>
                <div class="menu_item">
                    <i class='bx bx-signal-4'></i>
                    <p>Attendance</p>
                </div>
                <div class="menu_item">
                    <i class='bx bx-cog'></i>
                    <p>Settings</p>
                </div>
                <div class="menu_item">
                    <form method="POST" action="{{ url('/logout') }}" class="logout_form">
                        @csrf
                        <button type="submit" class="logout_btn">
                            <i class='bx bx-log-out'></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="main_content">
            <div class="left_right_sidebar_opener">
                <div class="hamburger">
                    <i class='bx bx-menu'></i>
                </div>
                <div class="student">
                    <div class="profile_img">
                        <img src="https://i.postimg.cc/Sxb6gssQ/img-1.jpg" alt="profile img">
                    </div>
                    <div class="profile_name">
                        <p>{{ $admin->name ?? 'Admin' }}</p>
                    </div>
                </div>
            </div>
            <div class="main_navbar">
                <div class="search_box">
                    <i class='bx bx-search-alt-2'></i> <input type="text" placeholder="Search">
                </div>
                <div class="dark_mode_icon" onclick="darkMode()">
                    <i class='bx bx-moon'></i>
                    <i class='bx bx-sun'></i>
                </div>
            </div>
            <div class="menu_item_name_and_filter">
                <div class="menu_item_name">
                    <h2>College Students</h2>
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
        </div>
    </div>
    <script src="{{ asset('js/table.js') }}"></script>
</body>
</html>
