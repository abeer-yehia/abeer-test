<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  email: user.email,
  profile_picture: null,

});
let fileError = '';

const handleFileChange = (event) => {
  const file = event.target.files ? event.target.files[0] : null;
  fileError = ''; // Reset the error message
  form.errors.clear('profile_picture');
  if (file) {
    const validFormats = ['image/jpeg', 'image/png'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    // File validation
    if (!validFormats.includes(file.type)) {
      fileError = 'The file must be a JPG or PNG image.';
      form.profile_picture = null; // Reset the file
      form.errors.set('profile_picture', fileError); // Set the error for file
    } else if (file.size > maxSize) {
      fileError = 'The file size must not exceed 2MB.';
      form.profile_picture = null; // Reset the file
      form.errors.set('profile_picture', fileError); // Set the error for file
    } else {
      form.profile_picture = file; // Assign the file to form object if valid
    }
  } else {
    form.profile_picture = null; // Reset file input if no file is selected
  }
};

// Handle the form submission
const handleSubmit = async () => {
  const formData = new FormData();  // Create a FormData object
  formData.append('name', form.name);
  formData.append('email', form.email);
  
  // Only append profile picture if it exists
  if (form.profile_picture) {
    formData.append('profile_picture', form.profile_picture);
  }

  // Make the request to update the profile
  form.processing = true;
  try {
    await form.post(route('profile.update'), {
      data: formData,
      forceFormData: true, // Ensure FormData is used
    });
  } catch (error) {
    form.processing = false;
  }
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

      <p class="mt-1 text-sm text-gray-600">
        Update your account's profile information and email address.
      </p>
    </header>

    <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
      <div>
        <InputLabel for="name" value="Name" />

        <TextInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
        />

        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div>
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="mt-2 text-sm text-gray-800">
          Your email address is unverified.
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-800 focus:ring-offset-2"
          >
            Click here to re-send the verification email.
          </Link>
        </p>

        <div
          v-show="status === 'verification-link-sent'"
          class="mt-2 text-sm font-medium text-green-600"
        >
          A new verification link has been sent to your email address.
        </div>
      </div>
    <!-- Profile Picture -->
    <div>
        <InputLabel for="profile_picture" value="Profile Picture" />

        <!-- Display current profile picture -->
        <img
          v-if="user.profile_picture_url"
          :src="user.profile_picture_url"
          alt="Profile Picture"
          class="mt-2 h-20 w-20 rounded-full object-cover"
        />

        <!-- File Input -->
        <input
          id="profile_picture"
          type="file"
          class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
          @change="handleFileChange"
        />


        <!-- Show file validation error -->
        <p v-if="fileError" class="text-sm text-red-600 mt-2">{{ fileError }}</p>

        <InputError v-if="form.errors.profile_picture" :message="form.errors.profile_picture" />
      </div>
      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
        </Transition>
      </div>
    </form>
  </section>
</template>
