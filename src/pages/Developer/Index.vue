<template>
  <q-page class="flex flex-center">
    <q-form action="/login" method="post" style="width: 90%; max-width: 520px">
      <q-card>
        <q-img src="https://colorlib.com/etc/lf/Login_v15/images/bg-01.jpg" class="q-py-lg">
          <div class="absolute-full text-h4 flex flex-center text-bold">SIGN IN</div>
        </q-img>
        <q-card-section class="q-gutter-y-sm">
          <q-input outlined label="Login Email" v-model="email" type="email" name="email" />
          <q-input outlined label="Password" v-model="password" type="password" name="password" />
          <input type="hidden" name="_token" v-model="_token" />
        </q-card-section>
        <q-card-actions class="bg-grey-2 q-py-md" align="right">
          <q-btn label="Proceed" color="primary" padding="sm md" type="submit" />
        </q-card-actions>
      </q-card>
    </q-form>
  </q-page>
</template>

<script setup>
import {ref} from "vue";

const email = ref('')
const password = ref('')
const _token = ref(document.getElementsByName('csrf-token')[0].content)
</script>
