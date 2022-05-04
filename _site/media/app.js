/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/hyde.ts":
/*!**********************************!*\
  !*** ./resources/assets/hyde.ts ***!
  \**********************************/
/***/ (() => {

/**
 * Core Scripts for the HydePHP Frontend
 *
 * @package     HydePHP - HydeFront
 * @version     v1.3.x (HydeFront)
 * @author      Caen De Silva
 */
var mainNavigationLinks = document.getElementById("main-navigation-links");
var openMainNavigationMenuIcon = document.getElementById("open-main-navigation-menu-icon");
var closeMainNavigationMenuIcon = document.getElementById("close-main-navigation-menu-icon");
var themeToggleButton = document.getElementById("theme-toggle-button");
var navigationToggleButton = document.getElementById("navigation-toggle-button");
var sidebarToggleButton = document.getElementById("sidebar-toggle-button");
var navigationOpen = false;

function toggleNavigation() {
  if (navigationOpen) {
    hideNavigation();
  } else {
    showNavigation();
  }
}

function showNavigation() {
  mainNavigationLinks.classList.remove("hidden");
  openMainNavigationMenuIcon.style.display = "none";
  closeMainNavigationMenuIcon.style.display = "block";
  navigationOpen = true;
}

function hideNavigation() {
  mainNavigationLinks.classList.add("hidden");
  openMainNavigationMenuIcon.style.display = "block";
  closeMainNavigationMenuIcon.style.display = "none";
  navigationOpen = false;
} // Handle the documentation page sidebar


var sidebarOpen = screen.width >= 768;
var sidebar = document.getElementById("documentation-sidebar");
var backdrop = document.getElementById("sidebar-backdrop");
var toggleButtons = document.querySelectorAll(".sidebar-button-wrapper");

function toggleSidebar() {
  if (sidebarOpen) {
    hideSidebar();
  } else {
    showSidebar();
  }
}

function showSidebar() {
  sidebar.classList.remove("hidden");
  sidebar.classList.add("flex");
  backdrop.classList.remove("hidden");
  document.getElementById("app").style.overflow = "hidden";
  toggleButtons.forEach(function (button) {
    button.classList.remove("open");
    button.classList.add("closed");
  });
  sidebarOpen = true;
}

function hideSidebar() {
  sidebar.classList.add("hidden");
  sidebar.classList.remove("flex");
  backdrop.classList.add("hidden");
  document.getElementById("app").style.overflow = null;
  toggleButtons.forEach(function (button) {
    button.classList.add("open");
    button.classList.remove("closed");
  });
  sidebarOpen = false;
} // Handle the theme switching


function toggleTheme() {
  if (isSelectedThemeDark()) {
    setThemeToLight();
  } else {
    setThemeToDark();
  }

  function isSelectedThemeDark() {
    return localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function setThemeToDark() {
    document.documentElement.classList.add("dark");
    localStorage.setItem('color-theme', 'dark');
  }

  function setThemeToLight() {
    document.documentElement.classList.remove("dark");
    localStorage.setItem('color-theme', 'light');
  }
} // Register onclick event listener for theme toggle button


themeToggleButton.onclick = toggleTheme; // Register onclick event listener for navigation toggle button if it exists

if (navigationToggleButton) {
  navigationToggleButton.onclick = toggleNavigation;
} // Register onclick event listener for sidebar toggle button if it exists


if (sidebarToggleButton) {
  sidebarToggleButton.onclick = toggleSidebar;
}

/***/ }),

/***/ "./resources/assets/app.js":
/*!*********************************!*\
  !*** ./resources/assets/app.js ***!
  \*********************************/
/***/ (() => {

/*
* This is the main JavaScript used by webpack to build the the app.js file. 
*/

/***/ }),

/***/ "./resources/assets/hyde.scss":
/*!************************************!*\
  !*** ./resources/assets/hyde.scss ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/app.css":
/*!**********************************!*\
  !*** ./resources/assets/app.css ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/app": 0,
/******/ 			"app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkhyde"] = self["webpackChunkhyde"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["app"], () => (__webpack_require__("./resources/assets/app.js")))
/******/ 	__webpack_require__.O(undefined, ["app"], () => (__webpack_require__("./resources/assets/hyde.ts")))
/******/ 	__webpack_require__.O(undefined, ["app"], () => (__webpack_require__("./resources/assets/hyde.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["app"], () => (__webpack_require__("./resources/assets/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	var __webpack_export_target__ = window;
/******/ 	for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
/******/ 	if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ 	
/******/ })()
;