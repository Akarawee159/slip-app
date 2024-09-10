<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar Example</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tailwind CSS CDN -->
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body class="bg-gray-100">


<!-- Mobile Menu Button -->
<div class="md:hidden flex items-center justify-between p-4 bg-gray-800 text-white">
    <span class="text-lg font-bold">My Dashboard</span>
    <button id="menu-toggle" class="text-white focus:outline-none">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>
</div>





<div class="flex h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out">
        <!-- Logo Section -->
        <div class="text-center text-2xl font-bold border-b border-gray-700 pb-4">
            My Dashboard
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-4">
            <a href="#" class="flex items-center space-x-3 hover:bg-gray-700 p-2 rounded-md">
                <i class="fas fa-tachometer-alt h-5 w-5 text-gray-400"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:bg-gray-700 p-2 rounded-md">
                <i class="fas fa-project-diagram h-5 w-5 text-gray-400"></i>
                <span>Projects</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:bg-gray-700 p-2 rounded-md">
                <i class="fas fa-tasks h-5 w-5 text-gray-400"></i>
                <span>Tasks</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:bg-gray-700 p-2 rounded-md">
                <i class="fas fa-chart-line h-5 w-5 text-gray-400"></i>
                <span>Reports</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:bg-gray-700 p-2 rounded-md">
                <i class="fas fa-cog h-5 w-5 text-gray-400"></i>
                <span>Settings</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:bg-gray-700 p-2 rounded-md">
                <i class="fas fa-sign-out-alt h-5 w-5 text-gray-400"></i>
                <span>Log Out</span>
            </a>
        </nav>
    </div>

    <!-- Main Content
    <div class="flex-1 p-10">
        <h1 class="text-3xl font-bold">Main Content</h1>
        <p>Some content goes here...</p>
    </div> -->
</div>


<!-- JavaScript for toggling sidebar on mobile -->
<script>
const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");

menuToggle.addEventListener("click", () => {
    sidebar.classList.toggle("-translate-x-full");
});

</script>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
