<template>
  <l-map
    ref="map"
    id="map--pageleaflet"
    class="full-heigth"
    :zoom="Number(zoom)"
    :center="center"
    @click="onMapClick"
    @update:center="doMoveCenter"
    @update:zoom="doMoveZoom"
    :min-zoom="14"
    :max-zoom="16"
    :key="`map-key-${zoom}-${center.lat}-${center.lng}`"
    @dblclick="onDbClick"
  >
    <l-tile-layer :url="MAP_URL" :attribution="ATTRIBUTION" />

    <l-marker
      :key="`marker-${markerKey}`"
      v-for="(marker, markerKey) in $props.markers"
      :lat-lng="marker"
      @click="(e) => onMarkerClick(e, markerKey)"
    />
  </l-map>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import 'leaflet/dist/leaflet.css';
import { latLng, LatLng, LocationEvent } from 'leaflet';

import { LMap, LMarker, LTileLayer } from '@vue-leaflet/vue-leaflet';

/**
 * ATTRIBUTION
 */
const ATTRIBUTION =
  '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors';
/**
 * MAP_URL
 */
// const MAP_URL = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const MAP_URL = 'atlas/{z}/{x}/{y}png.tile';

const $emit = defineEmits<{
  (e: 'map-click', p: LatLng): void;
  (e: 'map-dbclick', p: LatLng): void;
  (e: 'marker-click', p: { position: LatLng; key: number }): void;
}>();
const $props = defineProps<{
  markers: LatLng[];
}>();
/**
 * -----------------------------------------
 *	Data
 * -----------------------------------------
 */
const center = ref<LatLng>(latLng(22.1458, -80.4364));
const zoom = ref(16);
/**
 * -----------------------------------------
 *	Methods
 * -----------------------------------------
 */
/**
 * onMapClick
 */
function onMapClick(event: MouseEvent | PointerEvent | LocationEvent) {
  if ((event as LocationEvent).latlng) {
    $emit('map-click', (event as LocationEvent).latlng);
  }
}
/**
 * onMapClick
 */
function onDbClick(event: MouseEvent | LocationEvent) {
  if ((event as LocationEvent).latlng) {
    $emit('map-dbclick', (event as LocationEvent).latlng);
  }
}
/**
 * onMarkerClick
 */
function onMarkerClick(
  event: MouseEvent | PointerEvent | LocationEvent,
  key: number
) {
  if ((event as LocationEvent).latlng) {
    $emit('marker-click', { position: (event as LocationEvent).latlng, key });
  }
}
/**
 * doMoveCenter
 * @param _center
 */
function doMoveCenter(_center: LatLng) {
  center.value = _center;
}
/**
 * doMoveZoom
 * @param _zoom
 */
function doMoveZoom(_zoom: number) {
  if (_zoom >= 14 && _zoom <= 16) zoom.value = _zoom;
}
</script>
