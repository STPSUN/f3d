"use strict";var precacheConfig=[["/index.html","e6d140dfdfba4567384479641a5d2545"],["/static/css/main.dbbbf3d0.css","c782507b9209584a8485eadba615ea41"],["/static/js/main.37c510bc.js","be4e0ae342ca7e3ab21bce47ec570888"],["/static/media/banner1.67a8622e.png","67a8622e37fa74ae05f7181d166c5832"],["/static/media/bg-wallet.aa8d63eb.png","aa8d63ebc1d659307869cbff3918b267"],["/static/media/default_icon.bff1dee9.png","bff1dee902f79e35a9a03b43c724106d"],["/static/media/group1.77db12d2.png","77db12d2ad0fe9f1e906c91072ab6775"],["/static/media/group2.6cf0deea.png","6cf0deea5333b4442874f3a4aeb3148a"],["/static/media/group4.52fc70c2.png","52fc70c261d8bbd840dbf940fdd5cfed"],["/static/media/group5.389abbab.png","389abbab650dcfd549eb8b9f7745ab58"],["/static/media/group6.b89a7dd3.png","b89a7dd3abd781a319a7a959594cd97a"],["/static/media/headplayer.3ad72c21.png","3ad72c2150d6422a390ced4b5b307f27"],["/static/media/index_bg.241a6434.png","241a643495808582bae5bf84023f2cb0"],["/static/media/logo.3ad72c21.png","3ad72c2150d6422a390ced4b5b307f27"],["/static/media/mine_bg.41b1b445.png","41b1b445df68c0708d1c4ae9fe38e5ee"],["/static/media/share_page_bg.bc11646a.png","bc11646a1a0d32e061433fe13626d7fe"],["/static/media/transition_bg.035a10df.png","035a10df0daa0087b00086b6006142af"]],cacheName="sw-precache-v3-sw-precache-webpack-plugin-"+(self.registration?self.registration.scope:""),ignoreUrlParametersMatching=[/^utm_/],addDirectoryIndex=function(e,t){var a=new URL(e);return"/"===a.pathname.slice(-1)&&(a.pathname+=t),a.toString()},cleanResponse=function(t){return t.redirected?("body"in t?Promise.resolve(t.body):t.blob()).then(function(e){return new Response(e,{headers:t.headers,status:t.status,statusText:t.statusText})}):Promise.resolve(t)},createCacheKey=function(e,t,a,n){var r=new URL(e);return n&&r.pathname.match(n)||(r.search+=(r.search?"&":"")+encodeURIComponent(t)+"="+encodeURIComponent(a)),r.toString()},isPathWhitelisted=function(e,t){if(0===e.length)return!0;var a=new URL(t).pathname;return e.some(function(e){return a.match(e)})},stripIgnoredUrlParameters=function(e,a){var t=new URL(e);return t.hash="",t.search=t.search.slice(1).split("&").map(function(e){return e.split("=")}).filter(function(t){return a.every(function(e){return!e.test(t[0])})}).map(function(e){return e.join("=")}).join("&"),t.toString()},hashParamName="_sw-precache",urlsToCacheKeys=new Map(precacheConfig.map(function(e){var t=e[0],a=e[1],n=new URL(t,self.location),r=createCacheKey(n,hashParamName,a,/\.\w{8}\./);return[n.toString(),r]}));function setOfCachedUrls(e){return e.keys().then(function(e){return e.map(function(e){return e.url})}).then(function(e){return new Set(e)})}self.addEventListener("install",function(e){e.waitUntil(caches.open(cacheName).then(function(n){return setOfCachedUrls(n).then(function(a){return Promise.all(Array.from(urlsToCacheKeys.values()).map(function(t){if(!a.has(t)){var e=new Request(t,{credentials:"same-origin"});return fetch(e).then(function(e){if(!e.ok)throw new Error("Request for "+t+" returned a response with status "+e.status);return cleanResponse(e).then(function(e){return n.put(t,e)})})}}))})}).then(function(){return self.skipWaiting()}))}),self.addEventListener("activate",function(e){var a=new Set(urlsToCacheKeys.values());e.waitUntil(caches.open(cacheName).then(function(t){return t.keys().then(function(e){return Promise.all(e.map(function(e){if(!a.has(e.url))return t.delete(e)}))})}).then(function(){return self.clients.claim()}))}),self.addEventListener("fetch",function(t){if("GET"===t.request.method){var e,a=stripIgnoredUrlParameters(t.request.url,ignoreUrlParametersMatching),n="index.html";(e=urlsToCacheKeys.has(a))||(a=addDirectoryIndex(a,n),e=urlsToCacheKeys.has(a));var r="/index.html";!e&&"navigate"===t.request.mode&&isPathWhitelisted(["^(?!\\/__).*"],t.request.url)&&(a=new URL(r,self.location).toString(),e=urlsToCacheKeys.has(a)),e&&t.respondWith(caches.open(cacheName).then(function(e){return e.match(urlsToCacheKeys.get(a)).then(function(e){if(e)return e;throw Error("The cached response that was expected is missing.")})}).catch(function(e){return console.warn('Couldn\'t serve response for "%s" from cache: %O',t.request.url,e),fetch(t.request)}))}});