<template>
  <q-page padding>
    <q-card>
      <q-card-section>
        <map-widget
          :markers="markers"
          class="full-width"
          style="height: 90vh"
          @marker-click="onMarkerClick"
          @map-dbclick="onMapDoubleClick"
        />
      </q-card-section>
    </q-card>
  </q-page>

  <q-dialog v-model="dialogDetails" v-if="selectedCamera">
    <camera-widget
      :camera="selectedCamera"
      style="width: 25rem"
      @edit="onEdit"
    />
  </q-dialog>

  <q-dialog v-model="dialogForm" v-if="formPosition">
    <camera-form
      :position="formPosition"
      :update="selectedCamera"
      style="width: 25rem"
      @canceled="closeDialogs"
      @completed="onFormCompleted"
      @destroy="onDestroy"
    />
  </q-dialog>
</template>

<script lang="ts" setup>
import { latLng, LatLng } from 'leaflet';
import { $api } from 'src/boot/axios';
import MapWidget from 'src/components/widgets/MapWidget.vue';
import CameraForm from 'src/components/forms/CameraForm.vue';
import CameraWidget from 'src/components/widgets/CameraWidget.vue';
import { ICamera } from 'src/types';
import { computed, onBeforeMount, ref } from 'vue';
import { $notificationHelper } from 'src/helpers';
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */

const cameras = ref<ICamera[]>([]);
const dialogDetails = ref(false);
const dialogForm = ref(false);
const formPosition = ref<LatLng>();
const selectedCamera = ref<ICamera>();
const markers = computed(() => {
  const resp: LatLng[] = [];
  cameras.value.forEach((c) =>
    resp.push(latLng(c.position.lat, c.position.lng))
  );
  return resp;
});
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * Close Dialogs
 */
function closeDialogs() {
  dialogDetails.value = false;
  dialogForm.value = false;
  selectedCamera.value = undefined;
  formPosition.value = undefined;
}
/**
 * onDestroy
 * @param c
 */
function onDestroy(c: ICamera) {
  closeDialogs();
  const index = cameras.value.findIndex((_c) => _c.id === c.id);
  if (index >= 0) cameras.value.splice(index, 1);
}
/**
 * onEdit
 * @param c
 */
function onEdit(c: ICamera) {
  closeDialogs();
  selectedCamera.value = c;
  formPosition.value = latLng(c.position.lat, c.position.lng);
  dialogForm.value = true;
}
/**
 * onFormCompleted
 * @param c
 */
function onFormCompleted(c: ICamera) {
  const index = cameras.value.findIndex((_c) => _c.id === c.id);
  if (index >= 0) cameras.value[index] = c;
  else cameras.value.push(c);
  closeDialogs();
}
/**
 * On Marker Click
 * @param p
 */
function onMarkerClick(p: { position: LatLng; key: number }) {
  closeDialogs();
  selectedCamera.value = cameras.value[p.key];
  dialogDetails.value = true;
}
/**
 * On Map Double Click
 * @param p
 */
function onMapDoubleClick(p: LatLng) {
  closeDialogs();
  formPosition.value = p;
  dialogForm.value = true;
}
/**
 * On Before Mount
 */
onBeforeMount(async () => {
  $notificationHelper.loading();
  try {
    cameras.value = (await $api.get<ICamera[]>('api/cameras')).data;
  } catch (error) {
    $notificationHelper.axiosError(error);
  }
  $notificationHelper.loading(false);
});
</script>
