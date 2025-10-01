<template>
  <q-card class="text-center bg-grey-1" square flat>
    <q-card-section class="q-pa-none container text-center flex column content-stretch justify-between no-wrap" style="height: 100vh">
      <div class="card_design q-pt-md">
        <div class="half_transparent">
          <q-avatar :size="imageSize" class="text-center"><q-img :src="profile_photo" /></q-avatar>
        </div>
      </div>
      <div class="text-h2 font_secondary q-mt-md">{{ individual_name }}</div>
      <p class="text-uppercase text-subtitle1">{{ designation }}</p>
      <p class="text-subtitle1">{{ company_address }}</p>
      <p class="text-lowercase text-subtitle1">{{ email }}</p>
      <p class="text-lowercase text-subtitle1">{{ website }}</p>
      <div class="bg-primary q-py-md flex flex-center">
        <div class="q-gutter-x-lg">
          <q-btn icon="img:/assets/icons/PNG/Black/Youtube_black.png" round size="lg" color="white" text-color="primary" unelevated :href="youtube" target="_blank" />
          <q-btn icon="img:/assets/icons/PNG/Black/Facebook_black.png" round size="lg" color="white" text-color="primary" unelevated :href="facebook" target="_blank" />
          <q-btn icon="img:/assets/icons/PNG/Black/Instagram_black.png" round size="lg" color="white" text-color="primary" unelevated :href="instagram" target="_blank" />
        </div>
      </div>
      <p class="text-uppercase text-subtitle1 q-mt-md">{{ company_name }}</p>
    </q-card-section>
  </q-card>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps(['company_name','individual_name','profile_photo','designation','company_address','email','website','avatar_span_width','cover_photo','youtube','instagram','facebook','download'])

const imageSize = computed(() => props.avatar_span_width + "vw")
const cover_photo = computed(() => "url('" + props.cover_photo + "')")
const cover_photo_position = computed(() => "0vw " + (parseFloat(props.avatar_span_width)/2) + "vw")
</script>

<style>
.card_design {
  background-image: v-bind(cover_photo);
  background-size: cover;
  background-repeat: no-repeat;
}
.half_transparent {
  margin-bottom: -1px;
  background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAA1JREFUGFdj+PXr138ACc4D7jLQ4dsAAAAASUVORK5CYII=);
  background-position: v-bind(cover_photo_position);
  background-repeat: repeat-x;
  background-size: cover;
}
</style>
