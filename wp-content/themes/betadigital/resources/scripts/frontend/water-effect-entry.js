import WaterEffect from './components/water-effect';

const waterContainer = document.getElementById('water-effect-container');
if (waterContainer && window.innerWidth >= 768) {
  const boatImageUrl = waterContainer.dataset.boatImage;
  const waterMaskUrl = waterContainer.dataset.waterMask;
  if (boatImageUrl) {
    new WaterEffect(waterContainer, boatImageUrl, waterMaskUrl);
  }
}
