<template>
  <q-page>
    <q-list separator>
      <SettingsBrandAndColor />
      <SettingsAttributeParams />
      <SettingsLogoAndSize />
      <SettingsCompanyActions />
    </q-list>
  </q-page>
</template>

<script setup>
import SettingsBrandAndColor from "components/Settings/SettingsBrandAndColor.vue";
import SettingsAttributeParams from "components/Settings/SettingsAttributeParams.vue";
import SettingsLogoAndSize from "components/Settings/SettingsLogoAndSize.vue";
import SettingsCompanyActions from "components/Settings/SettingsCompanyActions.vue";
</script>
