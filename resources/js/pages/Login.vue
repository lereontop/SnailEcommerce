<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>

        <form @submit.prevent="handleLogin" class="space-y-4">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              type="email"
              id="email"
              v-model="form.email"
              placeholder="Enter your email"
              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-200"
              required
            />
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              type="password"
              id="password"
              v-model="form.password"
              placeholder="Enter your password"
              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-200"
              required
            />
          </div>

          <!-- Login Button -->
          <button
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-500 transition">
            Login
          </button>
        </form>

        <!-- Links -->
        <div class="mt-4 text-center text-sm text-gray-600">
          <a href="#" class="text-green-500 hover:underline">Forgot Password?</a>
          <p>
            Don’t have an account?
            <router-link to="/register" class="text-green-500 hover:underline">Sign Up</router-link>
          </p>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  import axios from "axios";

  const router = useRouter();
  const form = ref({
    email: "",
    password: "",
  });

  const handleLogin = async () => {
    try {
      // CSRF Protection: Ensure Sanctum can authenticate the user
      await axios.get("/sanctum/csrf-cookie");

      // Send login request to Laravel API
      const response = await axios.post("/login", form.value);

      // Extract token and user data
      const token = response.data.token;
      const user = response.data.user;

      // Store token & user info
      localStorage.setItem("token", token);
      localStorage.setItem("user", JSON.stringify(user));

      // Set default Authorization header for future requests
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

      // Redirect user based on role
      if (user.role === "admin") {
        router.push("/admin");
      } else {
        router.push("/");
      }
    } catch (error) {
      console.error("Login failed:", error.response?.data?.message || "An error occurred.");
    }
  };
  </script>
