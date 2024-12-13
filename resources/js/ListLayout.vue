<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
dayjs.extend(relativeTime);

const { props } = usePage();
const posts = ref(props.posts);

onMounted(() => {
  axios.get('/post')
    .then(response => {
      posts.value = response.data; 
      posts.value = response.data.map((post) => ({
        ...post,
        relativeTime: dayjs(post.created_at).fromNow(),
      }));
    })
    .catch(error => {
      console.error('Error fetching posts:', error);
    });
});
</script>

<template>
  <h1 class="uppercase text-center p-12 text-2xl font-bold text-red-800">Posts</h1>
    <div class="p-12">
      <div class="border-base-content/25 w-full overflow-x-auto border">
        <table class="table">
          <thead>
            <tr>
              <th class="text-stone-600/70">Title</th>
              <th class="text-stone-600/70">Description</th>
              <th class="text-stone-600/70">Date</th>
            </tr>
          </thead>
          <tbody>
            <!-- Loop through the posts array and display each post's title and description -->
            <tr v-for="post in posts" :key="post.id">
              <td class="text-nowrap text-zinc-800">{{ post.title }}</td>
              <td class="text-pretty ">{{ post.description }}</td>
              <td><span class="badge badge-soft badge-success text-xs">{{ post.relativeTime }}</span></td>
             
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>