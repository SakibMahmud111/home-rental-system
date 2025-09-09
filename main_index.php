<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <!-- Use Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <header class="bg-white shadow-md py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">My House Rental Project</h1>
            <nav>
                <a href="user_login.php" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300 transition-colors duration-200">Login</a>
                <a href="user_registration.php" class="ml-2 px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-full hover:bg-blue-600 transition-colors duration-200">Registration</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center p-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-gray-700 mb-4">Welcome to our platform!</h2>
            <p class="text-lg text-gray-500 mb-8">Find your dream home or list your property with ease.</p>
        </div>
    </main>

</body>
</html>
