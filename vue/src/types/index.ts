import { LatLng } from 'leaflet';

export interface ICamera {
  id: number;
  title: string;
  comments?: string;
  ip: string;
  model?: string;
  brand: string;
  dome: boolean;
  works: boolean;
  position: LatLng;
}
