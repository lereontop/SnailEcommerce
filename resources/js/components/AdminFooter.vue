<template>
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>
            &copy; {{ new Date().getFullYear() }} SnailStore Admin. All rights
            reserved.
        </p>
        <p>
            <RouterLink
                to="/admin/privacy-policy"
                class="underline hover:text-gray-400"
                >Privacy Policy</RouterLink
            >
        </p>
    </footer>
</template>
