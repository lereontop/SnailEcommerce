<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Register</h2>

        <form @submit.prevent="handleRegister" class="space-y-4">
          <!-- Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input
              type="text"
              id="name"
              v-model="form.name"
              placeholder="Enter your name"
              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-200"
              required
            />
          </div>

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

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input
              type="password"
              id="password_confirmation"
              v-model="form.passwordConfirmation"
              placeholder="Confirm your password"
              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-200"
              required
            />
          </div>

          <!-- Role Selection -->
          <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Select Role</label>
            <select
              id="role"
              v-model="form.role"
              class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-200"
              required
            >
              <option value="" disabled>Select Role</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <!-- Register Button -->
          <button
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-500 transition">
            Register
          </button>
        </form>

        <!-- Links -->
        <div class="mt-4 text-center text-sm text-gray-600">
          Already have an account?
          <router-link to="/login" class="text-green-500 hover:underline">Login</router-link>
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
    name: "",
    email: "",
    password: "",
    passwordConfirmation: "",
    role: "",
  });

  const handleRegister = async () => {
    if (form.value.password !== form.value.passwordConfirmation) {
      alert("Passwords do not match!");
      return;
    }

    try {
      // CSRF Protection (Needed for Laravel Sanctum)
      await axios.get("/sanctum/csrf-cookie");

      // Send register request
      const response = await axios.post("/register", {
        name: form.value.name,
        email: form.value.email,
        password: form.value.password,
        role: form.value.role,
      });

      alert(response.data.message);
      router.push("/login"); // Redirect to login after registration
    } catch (error) {
      alert(error.response?.data?.message || "Registration failed");
    }
  };
  </script>
