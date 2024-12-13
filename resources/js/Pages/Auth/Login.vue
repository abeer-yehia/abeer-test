<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, useField } from "vee-validate";
import { required, email, min } from "@vee-validate/rules";
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const isPasswordVisible = ref(false);

const togglePasswordVisibility = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

const passwordComplexity = (value) => {

  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  return (
    regex.test(value) ||
    "Password must be at least 8 characters long and contain a mix of uppercase, lowercase, numbers, and special characters."
  );
};

const loading = ref(false);

const { handleSubmit, reset, setErrors, errors, processing } = useForm({
  initialValues: {
    email: "",
    password: "",
    remember: false,
    
  },
});

const {
  value: emailValue,
  errorMessage: emailError,
  handleBlur: emailBlur,
} = useField("email", [required, email]);
const {
  value: passwordValue,
  errorMessage: passwordError,
  handleBlur: passwordBlur,
} = useField("password", [required, passwordComplexity]);

const submit = handleSubmit(async (values) => {
  try {
    loading.value = true;
    const response = await axios.post(route("login"), values);
    window.location.href = response.data.redirect || "/login";
  } catch (error) {
    if (error.response && error.response.status === 422) {
      setErrors(error.response.data.errors);
    }
  }finally {
    loading.value = false; 
  }
});
</script>

<template>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

  <GuestLayout>
    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" class="text-green-800"/>

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="emailValue"
          :class="{ 'border-red-500': emailError, 'border-gray-300': !emailError }"
          required
          autofocus
          autocomplete="username"
          @blur="emailBlur"
        />

        <InputError v-if="emailError" class="mt-2 text-red-600" :message="emailError" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" class="text-green-800" />
        <div class="relative">
          <TextInput
            id="password"
            :type="isPasswordVisible ? 'text' : 'password'"
            class="mt-1 block w-full"
            v-model="passwordValue"
            :class="{
              'border-red-500': passwordError,
              'border-gray-300': !passwordError,
            }"
            required
            autocomplete="current-password"
            @blur="passwordBlur"
          />
          <!-- Toggle Button -->
          <button
            type="button"
            @click="togglePasswordVisibility"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none"
          >
            <span v-if="isPasswordVisible">
              <!-- Eye Icon -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                color="green"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-eye"
              >
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                <path
                  d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"
                />
              </svg>
            </span>
            <span v-else>
              <!-- Eye-off Icon -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                color="green"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"
              >
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                <path
                  d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87"
                />
                <path d="M3 3l18 18" />
              </svg>
            </span>
          </button>
        </div>
        <InputError
          v-if="passwordError"
          class="mt-2 text-red-600"
          :message="passwordError"
        />
      </div>

      <div class="mt-4 block">
        <label class="flex items-center">
          <Checkbox v-model="remember" />
          <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <div class="mt-4 flex items-center justify-end">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-800 focus:ring-offset-2"
        >
          Forgot your password?
        </Link>

        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': processing }"
          :disabled="processing"
        >
          <div v-if="loading" role="status">
            <svg
              aria-hidden="true"
              class="w-4 h-4 me-3 inline text-gray-200 animate-spin dark:text-white fill-green-50"
              viewBox="0 0 100 101"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor"
              />
              <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill"
              />
            </svg>
            <span  class="sr-only">Loading...</span>
          </div>
         <span  v-else> Log in</span> 
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
