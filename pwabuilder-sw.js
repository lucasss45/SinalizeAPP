
let bah = document.getElementById("bah");
let vixe = document.getElementById("vixe"); 

function funcTeste() {
  console.log("Tá puxando a função");
  vixe.setAttribute('onclick', 'funcTeste2()');
  bah.setAttribute('src', 'Design/Design Alpha 1.9/Imagens/Vel-rápido.jpg');
}

function funcTeste2() {
  console.log("Tá puxando a função 2");
  vixe.setAttribute('onclick', 'funcTeste3()');
  bah.setAttribute('src', 'Design/Design Alpha 1.9/Imagens/Vel-devagar.jpg');
}

function funcTeste3() {
  console.log("Tá puxando a função 3");
  vixe.setAttribute('onclick', 'funcTeste()');
  bah.setAttribute('src', 'Design/Design Alpha 1.9/Imagens/Velocidade.jpg');
}


// This is the "Offline page" service worker

//importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');

//const CACHE = "pwabuilder-page";

// TODO: replace the following with the correct offline fallback page i.e.: const offlineFallbackPage = "offline.html";
//const offlineFallbackPage = "ToDo-replace-this-name.html";

//self.addEventListener("message", (event) => {
  //if (event.data && event.data.type === "SKIP_WAITING") {
    //self.skipWaiting();
  //}
//});

//self.addEventListener('install', async (event) => {
  //event.waitUntil(
    //caches.open(CACHE)
      //.then((cache) => cache.add(offlineFallbackPage))
  //);
//});

//if (workbox.navigationPreload.isSupported()) {
  //workbox.navigationPreload.enable();
//}

//self.addEventListener('fetch', (event) => {
  //if (event.request.mode === 'navigate') {
    //event.respondWith((async () => {
      //try {
        //const preloadResp = await event.preloadResponse;

        //if (preloadResp) {
          //return preloadResp;
        //}

        //const networkResp = await fetch(event.request);
        //return networkResp;
      //} catch (error) {

//        const cache = await caches.open(CACHE);
 //       const cachedResp = await cache.match(offlineFallbackPage);
//        return cachedResp;
//      }
//    })());
//  }
//});