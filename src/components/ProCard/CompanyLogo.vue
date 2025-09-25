<template>
  <div class="company-logo q-my-md q-mx-auto" style="width: 60%">&nbsp;</div>
</template>

<script setup>
import {computed, reactive} from "vue";
import { useQuasar } from "quasar";
import {get} from "lodash";
const $q = useQuasar();

const logo = reactive({ url:'', width:'', height:'' });
const { url,width,height } = get(__DATA,['company','logo'])
logo.url = url || './logos/template/EliteCard.png';
logo.width = width ? parseInt(width) : 875;
logo.height = height ? parseInt(height) : 619;
let logo_span = computed(() => parseInt(get(__DATA,['layout','logo_span'],14) || 14))
let display_height = computed(() => parseInt($q.screen.height * logo_span.value / 100) + 'px')
let background_image = computed(() => 'url("' +logo.url+ '")')
</script>

<style>
.company-logo {
  background-image: v-bind(background_image);
  height: v-bind(display_height);
  width: 100%;
  background-position: center;
  background-size: contain;
  background-repeat: no-repeat;
}
</style>
