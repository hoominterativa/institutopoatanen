/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@ckeditor/ckeditor5-core/src/contextplugin.js":
/*!********************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-core/src/contextplugin.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ContextPlugin)
/* harmony export */ });
/* harmony import */ var _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/observablemixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/mix */ "./node_modules/@ckeditor/ckeditor5-utils/src/mix.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module core/contextplugin
 */




/**
 * The base class for {@link module:core/context~Context} plugin classes.
 *
 * A context plugin can either be initialized for an {@link module:core/editor/editor~Editor editor} or for
 * a {@link module:core/context~Context context}. In other words, it can either
 * work within one editor instance or with one or more editor instances that use a single context.
 * It is the context plugin's role to implement handling for both modes.
 *
 * There are a few rules for interaction between the editor plugins and context plugins:
 *
 * * A context plugin can require another context plugin.
 * * An {@link module:core/plugin~Plugin editor plugin} can require a context plugin.
 * * A context plugin MUST NOT require an {@link module:core/plugin~Plugin editor plugin}.
 *
 * @implements module:core/plugin~PluginInterface
 * @mixes module:utils/observablemixin~ObservableMixin
 */
class ContextPlugin {
	/**
	 * Creates a new plugin instance.
	 *
	 * @param {module:core/context~Context|module:core/editor/editor~Editor} context
	 */
	constructor( context ) {
		/**
		 * The context instance.
		 *
		 * @readonly
		 * @type {module:core/context~Context|module:core/editor/editor~Editor}
		 */
		this.context = context;
	}

	/**
	 * @inheritDoc
	 */
	destroy() {
		this.stopListening();
	}

	/**
	 * @inheritDoc
	 */
	static get isContextPlugin() {
		return true;
	}
}

(0,_ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_1__.default)( ContextPlugin, _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_0__.default );


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-core/src/pendingactions.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-core/src/pendingactions.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ PendingActions)
/* harmony export */ });
/* harmony import */ var _contextplugin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./contextplugin */ "./node_modules/@ckeditor/ckeditor5-core/src/contextplugin.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/observablemixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_collection__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/collection */ "./node_modules/@ckeditor/ckeditor5-utils/src/collection.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module core/pendingactions
 */






/**
 * The list of pending editor actions.
 *
 * This plugin should be used to synchronise plugins that execute long-lasting actions
 * (e.g. file upload) with the editor integration. It gives the developer who integrates the editor
 * an easy way to check if there are any actions pending whenever such information is needed.
 * All plugins that register a pending action also provide a message about the action that is ongoing
 * which can be displayed to the user. This lets them decide if they want to interrupt the action or wait.
 *
 * Adding and updating a pending action:
 *
 * 		const pendingActions = editor.plugins.get( 'PendingActions' );
 * 		const action = pendingActions.add( 'Upload in progress: 0%.' );
 *
 *		// You can update the message:
 * 		action.message = 'Upload in progress: 10%.';
 *
 * Removing a pending action:
 *
 * 		const pendingActions = editor.plugins.get( 'PendingActions' );
 * 		const action = pendingActions.add( 'Unsaved changes.' );
 *
 * 		pendingActions.remove( action );
 *
 * Getting pending actions:
 *
 * 		const pendingActions = editor.plugins.get( 'PendingActions' );
 *
 * 		const action1 = pendingActions.add( 'Action 1' );
 * 		const action2 = pendingActions.add( 'Action 2' );
 *
 * 		pendingActions.first; // Returns action1
 * 		Array.from( pendingActions ); // Returns [ action1, action2 ]
 *
 * This plugin is used by features like {@link module:upload/filerepository~FileRepository} to register their ongoing actions
 * and by features like {@link module:autosave/autosave~Autosave} to detect whether there are any ongoing actions.
 * Read more about saving the data in the {@glink builds/guides/integration/saving-data Saving and getting data} guide.
 *
 * @extends module:core/contextplugin~ContextPlugin
 */
class PendingActions extends _contextplugin__WEBPACK_IMPORTED_MODULE_0__.default {
	/**
	 * @inheritDoc
	 */
	static get pluginName() {
		return 'PendingActions';
	}

	/**
	 * @inheritDoc
	 */
	init() {
		/**
		 * Defines whether there is any registered pending action.
		 *
		 * @readonly
		 * @observable
		 * @member {Boolean} #hasAny
		 */
		this.set( 'hasAny', false );

		/**
		 * A list of pending actions.
		 *
		 * @private
		 * @type {module:utils/collection~Collection}
		 */
		this._actions = new _ckeditor_ckeditor5_utils_src_collection__WEBPACK_IMPORTED_MODULE_2__.default( { idProperty: '_id' } );
		this._actions.delegate( 'add', 'remove' ).to( this );
	}

	/**
	 * Adds an action to the list of pending actions.
	 *
	 * This method returns an action object with an observable message property.
	 * The action object can be later used in the {@link #remove} method. It also allows you to change the message.
	 *
	 * @param {String} message The action message.
	 * @returns {Object} An observable object that represents a pending action.
	 */
	add( message ) {
		if ( typeof message !== 'string' ) {
			/**
			 * The message must be a string.
			 *
			 * @error pendingactions-add-invalid-message
			 */
			throw new _ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_3__.default( 'pendingactions-add-invalid-message', this );
		}

		const action = Object.create( _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_1__.default );

		action.set( 'message', message );
		this._actions.add( action );
		this.hasAny = true;

		return action;
	}

	/**
	 * Removes an action from the list of pending actions.
	 *
	 * @param {Object} action An action object.
	 */
	remove( action ) {
		this._actions.remove( action );
		this.hasAny = !!this._actions.length;
	}

	/**
	 * Returns the first action from the list or null when list is empty
	 *
	 * returns {Object|null} The pending action object.
	 */
	get first() {
		return this._actions.get( 0 );
	}

	/**
	 * Iterable interface.
	 *
	 * @returns {Iterable.<*>}
	 */
	[ Symbol.iterator ]() {
		return this._actions[ Symbol.iterator ]();
	}

	/**
	 * Fired when an action is added to the list.
	 *
	 * @event add
	 * @param {Object} action The added action.
	 */

	/**
	 * Fired when an action is removed from the list.
	 *
	 * @event remove
	 * @param {Object} action The removed action.
	 */
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-core/src/plugin.js":
/*!*************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-core/src/plugin.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Plugin)
/* harmony export */ });
/* harmony import */ var _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/observablemixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/mix */ "./node_modules/@ckeditor/ckeditor5-utils/src/mix.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module core/plugin
 */




/**
 * The base class for CKEditor plugin classes.
 *
 * @implements module:core/plugin~PluginInterface
 * @mixes module:utils/observablemixin~ObservableMixin
 */
class Plugin {
	/**
	 * @inheritDoc
	 */
	constructor( editor ) {
		/**
		 * The editor instance.
		 *
		 * Note that most editors implement the {@link module:core/editor/editorwithui~EditorWithUI} interface in addition
		 * to the base {@link module:core/editor/editor~Editor} interface. However, editors with an external UI
		 * (i.e. Bootstrap-based) or a headless editor may not implement the {@link module:core/editor/editorwithui~EditorWithUI}
		 * interface.
		 *
		 * Because of above, to make plugins more universal, it is recommended to split features into:
		 *  - The "editing" part that only uses the {@link module:core/editor/editor~Editor} interface.
		 *  - The "UI" part that uses both the {@link module:core/editor/editor~Editor} interface and
		 *  the {@link module:core/editor/editorwithui~EditorWithUI} interface.
		 *
		 * @readonly
		 * @member {module:core/editor/editor~Editor} #editor
		 */
		this.editor = editor;

		/**
		 * Flag indicating whether a plugin is enabled or disabled.
		 * A disabled plugin will not transform text.
		 *
		 * Plugin can be simply disabled like that:
		 *
		 *		// Disable the plugin so that no toolbars are visible.
		 *		editor.plugins.get( 'TextTransformation' ).isEnabled = false;
		 *
		 * You can also use {@link #forceDisabled} method.
		 *
		 * @observable
		 * @readonly
		 * @member {Boolean} #isEnabled
		 */
		this.set( 'isEnabled', true );

		/**
		 * Holds identifiers for {@link #forceDisabled} mechanism.
		 *
		 * @type {Set.<String>}
		 * @private
		 */
		this._disableStack = new Set();
	}

	/**
	 * Disables the plugin.
	 *
	 * Plugin may be disabled by multiple features or algorithms (at once). When disabling a plugin, unique id should be passed
	 * (e.g. feature name). The same identifier should be used when {@link #clearForceDisabled enabling back} the plugin.
	 * The plugin becomes enabled only after all features {@link #clearForceDisabled enabled it back}.
	 *
	 * Disabling and enabling a plugin:
	 *
	 *		plugin.isEnabled; // -> true
	 *		plugin.forceDisabled( 'MyFeature' );
	 *		plugin.isEnabled; // -> false
	 *		plugin.clearForceDisabled( 'MyFeature' );
	 *		plugin.isEnabled; // -> true
	 *
	 * Plugin disabled by multiple features:
	 *
	 *		plugin.forceDisabled( 'MyFeature' );
	 *		plugin.forceDisabled( 'OtherFeature' );
	 *		plugin.clearForceDisabled( 'MyFeature' );
	 *		plugin.isEnabled; // -> false
	 *		plugin.clearForceDisabled( 'OtherFeature' );
	 *		plugin.isEnabled; // -> true
	 *
	 * Multiple disabling with the same identifier is redundant:
	 *
	 *		plugin.forceDisabled( 'MyFeature' );
	 *		plugin.forceDisabled( 'MyFeature' );
	 *		plugin.clearForceDisabled( 'MyFeature' );
	 *		plugin.isEnabled; // -> true
	 *
	 * **Note:** some plugins or algorithms may have more complex logic when it comes to enabling or disabling certain plugins,
	 * so the plugin might be still disabled after {@link #clearForceDisabled} was used.
	 *
	 * @param {String} id Unique identifier for disabling. Use the same id when {@link #clearForceDisabled enabling back} the plugin.
	 */
	forceDisabled( id ) {
		this._disableStack.add( id );

		if ( this._disableStack.size == 1 ) {
			this.on( 'set:isEnabled', forceDisable, { priority: 'highest' } );
			this.isEnabled = false;
		}
	}

	/**
	 * Clears forced disable previously set through {@link #forceDisabled}. See {@link #forceDisabled}.
	 *
	 * @param {String} id Unique identifier, equal to the one passed in {@link #forceDisabled} call.
	 */
	clearForceDisabled( id ) {
		this._disableStack.delete( id );

		if ( this._disableStack.size == 0 ) {
			this.off( 'set:isEnabled', forceDisable );
			this.isEnabled = true;
		}
	}

	/**
	 * @inheritDoc
	 */
	destroy() {
		this.stopListening();
	}

	/**
	 * @inheritDoc
	 */
	static get isContextPlugin() {
		return false;
	}
}

(0,_ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_1__.default)( Plugin, _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_0__.default );

/**
 * The base interface for CKEditor plugins.
 *
 * In its minimal form a plugin can be a simple function that accepts {@link module:core/editor/editor~Editor the editor}
 * as a parameter:
 *
 *		// A simple plugin that enables a data processor.
 *		function MyPlugin( editor ) {
 *			editor.data.processor = new MyDataProcessor();
 *		}
 *
 * In most cases however, you will want to inherit from the {@link module:core/plugin~Plugin} class which implements the
 * {@link module:utils/observablemixin~ObservableMixin} and is, therefore, more convenient:
 *
 *		class MyPlugin extends Plugin {
 *			init() {
 *				// `listenTo()` and `editor` are available thanks to `Plugin`.
 *				// By using `listenTo()` you will ensure that the listener is removed when
 *				// the plugin is destroyed.
 *				this.listenTo( this.editor.data, 'ready', () => {
 *					// Do something when the data is ready.
 *				} );
 *			}
 *		}
 *
 * The plugin can also implement methods (e.g. {@link module:core/plugin~PluginInterface#init `init()`} or
 * {@link module:core/plugin~PluginInterface#destroy `destroy()`}) which, when present, will be used to properly
 * initialize and destroy the plugin.
 *
 * **Note:** When defined as a plain function, the plugin acts as a constructor and will be
 * called in parallel with other plugins' {@link module:core/plugin~PluginInterface#constructor constructors}.
 * This means the code of that plugin will be executed **before** {@link module:core/plugin~PluginInterface#init `init()`} and
 * {@link module:core/plugin~PluginInterface#afterInit `afterInit()`} methods of other plugins and, for instance,
 * you cannot use it to extend other plugins' {@glink framework/guides/architecture/editing-engine#schema schema}
 * rules as they are defined later on during the `init()` stage.
 *
 * @interface PluginInterface
 */

/**
 * Creates a new plugin instance. This is the first step of the plugin initialization.
 * See also {@link #init} and {@link #afterInit}.
 *
 * A plugin is always instantiated after its {@link module:core/plugin~PluginInterface.requires dependencies} and the
 * {@link #init} and {@link #afterInit} methods are called in the same order.
 *
 * Usually, you will want to put your plugin's initialization code in the {@link #init} method.
 * The constructor can be understood as "before init" and used in special cases, just like
 * {@link #afterInit} serves the special "after init" scenarios (e.g.the code which depends on other
 * plugins, but which does not {@link module:core/plugin~PluginInterface.requires explicitly require} them).
 *
 * @method #constructor
 * @param {module:core/editor/editor~Editor} editor
 */

/**
 * An array of plugins required by this plugin.
 *
 * To keep the plugin class definition tight it is recommended to define this property as a static getter:
 *
 *		import Image from './image.js';
 *
 *		export default class ImageCaption {
 *			static get requires() {
 *				return [ Image ];
 *			}
 *		}
 *
 * @static
 * @readonly
 * @member {Array.<Function>|undefined} module:core/plugin~PluginInterface.requires
 */

/**
 * An optional name of the plugin. If set, the plugin will be available in
 * {@link module:core/plugincollection~PluginCollection#get} by its
 * name and its constructor. If not, then only by its constructor.
 *
 * The name should reflect the constructor name.
 *
 * To keep the plugin class definition tight, it is recommended to define this property as a static getter:
 *
 *		export default class ImageCaption {
 *			static get pluginName() {
 *				return 'ImageCaption';
 *			}
 *		}
 *
 * Note: The native `Function.name` property could not be used to keep the plugin name because
 * it will be mangled during code minification.
 *
 * Naming a plugin is necessary to enable removing it through the
 * {@link module:core/editor/editorconfig~EditorConfig#removePlugins `config.removePlugins`} option.
 *
 * @static
 * @readonly
 * @member {String|undefined} module:core/plugin~PluginInterface.pluginName
 */

/**
 * The second stage (after plugin {@link #constructor}) of the plugin initialization.
 * Unlike the plugin constructor this method can be asynchronous.
 *
 * A plugin's `init()` method is called after its {@link module:core/plugin~PluginInterface.requires dependencies} are initialized,
 * so in the same order as the constructors of these plugins.
 *
 * **Note:** This method is optional. A plugin instance does not need to have it defined.
 *
 * @method #init
 * @returns {null|Promise}
 */

/**
 * The third (and last) stage of the plugin initialization. See also {@link #constructor} and {@link #init}.
 *
 * **Note:** This method is optional. A plugin instance does not need to have it defined.
 *
 * @method #afterInit
 * @returns {null|Promise}
 */

/**
 * Destroys the plugin.
 *
 * **Note:** This method is optional. A plugin instance does not need to have it defined.
 *
 * @method #destroy
 * @returns {null|Promise}
 */

/**
 * A flag which defines if a plugin is allowed or not allowed to be used directly by a {@link module:core/context~Context}.
 *
 * @static
 * @readonly
 * @member {Boolean} module:core/plugin~PluginInterface.isContextPlugin
 */

/**
 * An array of loaded plugins.
 *
 * @typedef {Array.<module:core/plugin~PluginInterface>} module:core/plugin~LoadedPlugins
 */

// Helper function that forces plugin to be disabled.
function forceDisable( evt ) {
	evt.return = false;
	evt.stop();
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter.js":
/*!*************************************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter.js ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ SimpleUploadAdapter)
/* harmony export */ });
/* harmony import */ var _ckeditor_ckeditor5_core_src_plugin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @ckeditor/ckeditor5-core/src/plugin */ "./node_modules/@ckeditor/ckeditor5-core/src/plugin.js");
/* harmony import */ var _filerepository__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../filerepository */ "./node_modules/@ckeditor/ckeditor5-upload/src/filerepository.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module upload/adapters/simpleuploadadapter
 */

/* globals XMLHttpRequest, FormData */





/**
 * The Simple upload adapter allows uploading images to an application running on your server using
 * the [`XMLHttpRequest`](https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest) API with a
 * minimal {@link module:upload/adapters/simpleuploadadapter~SimpleUploadConfig editor configuration}.
 *
 *		ClassicEditor
 *			.create( document.querySelector( '#editor' ), {
 *				simpleUpload: {
 *					uploadUrl: 'http://example.com',
 *					headers: {
 *						...
 *					}
 *				}
 *			} )
 *			.then( ... )
 *			.catch( ... );
 *
 * See the {@glink features/images/image-upload/simple-upload-adapter "Simple upload adapter"} guide to learn how to
 * learn more about the feature (configuration, server–side requirements, etc.).
 *
 * Check out the {@glink features/images/image-upload/image-upload comprehensive "Image upload overview"} to learn about
 * other ways to upload images into CKEditor 5.
 *
 * @extends module:core/plugin~Plugin
 */
class SimpleUploadAdapter extends _ckeditor_ckeditor5_core_src_plugin__WEBPACK_IMPORTED_MODULE_0__.default {
	/**
	 * @inheritDoc
	 */
	static get requires() {
		return [ _filerepository__WEBPACK_IMPORTED_MODULE_1__.default ];
	}

	/**
	 * @inheritDoc
	 */
	static get pluginName() {
		return 'SimpleUploadAdapter';
	}

	/**
	 * @inheritDoc
	 */
	init() {
		const options = this.editor.config.get( 'simpleUpload' );

		if ( !options ) {
			return;
		}

		if ( !options.uploadUrl ) {
			/**
			 * The {@link module:upload/adapters/simpleuploadadapter~SimpleUploadConfig#uploadUrl `config.simpleUpload.uploadUrl`}
			 * configuration required by the {@link module:upload/adapters/simpleuploadadapter~SimpleUploadAdapter `SimpleUploadAdapter`}
			 * is missing. Make sure the correct URL is specified for the image upload to work properly.
			 *
			 * @error simple-upload-adapter-missing-uploadurl
			 */
			(0,_ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_2__.logWarning)( 'simple-upload-adapter-missing-uploadurl' );

			return;
		}

		this.editor.plugins.get( _filerepository__WEBPACK_IMPORTED_MODULE_1__.default ).createUploadAdapter = loader => {
			return new Adapter( loader, options );
		};
	}
}

/**
 * Upload adapter.
 *
 * @private
 * @implements module:upload/filerepository~UploadAdapter
 */
class Adapter {
	/**
	 * Creates a new adapter instance.
	 *
	 * @param {module:upload/filerepository~FileLoader} loader
	 * @param {module:upload/adapters/simpleuploadadapter~SimpleUploadConfig} options
	 */
	constructor( loader, options ) {
		/**
		 * FileLoader instance to use during the upload.
		 *
		 * @member {module:upload/filerepository~FileLoader} #loader
		 */
		this.loader = loader;

		/**
		 * The configuration of the adapter.
		 *
		 * @member {module:upload/adapters/simpleuploadadapter~SimpleUploadConfig} #options
		 */
		this.options = options;
	}

	/**
	 * Starts the upload process.
	 *
	 * @see module:upload/filerepository~UploadAdapter#upload
	 * @returns {Promise}
	 */
	upload() {
		return this.loader.file
			.then( file => new Promise( ( resolve, reject ) => {
				this._initRequest();
				this._initListeners( resolve, reject, file );
				this._sendRequest( file );
			} ) );
	}

	/**
	 * Aborts the upload process.
	 *
	 * @see module:upload/filerepository~UploadAdapter#abort
	 * @returns {Promise}
	 */
	abort() {
		if ( this.xhr ) {
			this.xhr.abort();
		}
	}

	/**
	 * Initializes the `XMLHttpRequest` object using the URL specified as
	 * {@link module:upload/adapters/simpleuploadadapter~SimpleUploadConfig#uploadUrl `simpleUpload.uploadUrl`} in the editor's
	 * configuration.
	 *
	 * @private
	 */
	_initRequest() {
		const xhr = this.xhr = new XMLHttpRequest();

		xhr.open( 'POST', this.options.uploadUrl, true );
		xhr.responseType = 'json';
	}

	/**
	 * Initializes XMLHttpRequest listeners
	 *
	 * @private
	 * @param {Function} resolve Callback function to be called when the request is successful.
	 * @param {Function} reject Callback function to be called when the request cannot be completed.
	 * @param {File} file Native File object.
	 */
	_initListeners( resolve, reject, file ) {
		const xhr = this.xhr;
		const loader = this.loader;
		const genericErrorText = `Couldn't upload file: ${ file.name }.`;

		xhr.addEventListener( 'error', () => reject( genericErrorText ) );
		xhr.addEventListener( 'abort', () => reject() );
		xhr.addEventListener( 'load', () => {
			const response = xhr.response;

			if ( !response || response.error ) {
				return reject( response && response.error && response.error.message ? response.error.message : genericErrorText );
			}

			const urls = response.url ? { default: response.url } : response.urls;

			// Resolve with the normalized `urls` property and pass the rest of the response
			// to allow customizing the behavior of features relying on the upload adapters.
			resolve( {
				...response,
				urls
			} );
		} );

		// Upload progress when it is supported.
		/* istanbul ignore else */
		if ( xhr.upload ) {
			xhr.upload.addEventListener( 'progress', evt => {
				if ( evt.lengthComputable ) {
					loader.uploadTotal = evt.total;
					loader.uploaded = evt.loaded;
				}
			} );
		}
	}

	/**
	 * Prepares the data and sends the request.
	 *
	 * @private
	 * @param {File} file File instance to be uploaded.
	 */
	_sendRequest( file ) {
		// Set headers if specified.
		const headers = this.options.headers || {};

		// Use the withCredentials flag if specified.
		const withCredentials = this.options.withCredentials || false;

		for ( const headerName of Object.keys( headers ) ) {
			this.xhr.setRequestHeader( headerName, headers[ headerName ] );
		}

		this.xhr.withCredentials = withCredentials;

		// Prepare the form data.
		const data = new FormData();

		data.append( 'upload', file );

		// Send the request.
		this.xhr.send( data );
	}
}

/**
 * The configuration of the {@link module:upload/adapters/simpleuploadadapter~SimpleUploadAdapter simple upload adapter}.
 *
 *		ClassicEditor
 *			.create( editorElement, {
 *				simpleUpload: {
 *					// The URL the images are uploaded to.
 *					uploadUrl: 'http://example.com',
 *
 *					// Headers sent along with the XMLHttpRequest to the upload server.
 *					headers: {
 *						...
 *					}
 *				}
 *			} );
 *			.then( ... )
 *			.catch( ... );
 *
 * See the {@glink features/images/image-upload/simple-upload-adapter "Simple upload adapter"} guide to learn more.
 *
 * See {@link module:core/editor/editorconfig~EditorConfig all editor configuration options}.
 *
 * @interface SimpleUploadConfig
 */

/**
 * The configuration of the {@link module:upload/adapters/simpleuploadadapter~SimpleUploadAdapter simple upload adapter}.
 *
 * Read more in {@link module:upload/adapters/simpleuploadadapter~SimpleUploadConfig}.
 *
 * @member {module:upload/adapters/simpleuploadadapter~SimpleUploadConfig} module:core/editor/editorconfig~EditorConfig#simpleUpload
 */

/**
 * The path (URL) to the server (application) which handles the file upload. When specified, enables the automatic
 * upload of resources (images) inserted into the editor content.
 *
 * Learn more about the server application requirements in the
 * {@glink features/images/image-upload/simple-upload-adapter#server-side-configuration "Server-side configuration"} section
 * of the feature guide.
 *
 * @member {String} module:upload/adapters/simpleuploadadapter~SimpleUploadConfig#uploadUrl
 */

/**
 * An object that defines additional [headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers) sent with
 * the request to the server during the upload. This is the right place to implement security mechanisms like
 * authentication and [CSRF](https://developer.mozilla.org/en-US/docs/Glossary/CSRF) protection.
 *
 *		ClassicEditor
 *			.create( editorElement, {
 *				simpleUpload: {
 *					headers: {
 *						'X-CSRF-TOKEN': 'CSRF-Token',
 *						Authorization: 'Bearer <JSON Web Token>'
 *					}
 *				}
 *			} );
 *			.then( ... )
 *			.catch( ... );
 *
 * Learn more about the server application requirements in the
 * {@glink features/images/image-upload/simple-upload-adapter#server-side-configuration "Server-side configuration"} section
 * of the feature guide.
 *
 * @member {Object.<String, String>} module:upload/adapters/simpleuploadadapter~SimpleUploadConfig#headers
 */

/**
 * This flag enables the
 * [`withCredentials`](https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/withCredentials)
 * property of the request sent to the server during the upload. It affects cross-site requests only and, for instance,
 * allows credentials such as cookies to be sent along with the request.
 *
 *		ClassicEditor
 *			.create( editorElement, {
 *				simpleUpload: {
 *					withCredentials: true
 *				}
 *			} );
 *			.then( ... )
 *			.catch( ... );
 *
 * Learn more about the server application requirements in the
 * {@glink features/images/image-upload/simple-upload-adapter#server-side-configuration "Server-side configuration"} section
 * of the feature guide.
 *
 * @member {Boolean} [module:upload/adapters/simpleuploadadapter~SimpleUploadConfig#withCredentials=false]
 */


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-upload/src/filereader.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-upload/src/filereader.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ FileReader)
/* harmony export */ });
/* harmony import */ var _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/observablemixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/mix */ "./node_modules/@ckeditor/ckeditor5-utils/src/mix.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module upload/filereader
 */

/* globals window */




/**
 * Wrapper over the native `FileReader`.
 */
class FileReader {
	/**
	 * Creates an instance of the FileReader.
	 */
	constructor() {
		const reader = new window.FileReader();

		/**
		 * Instance of native FileReader.
		 *
		 * @private
		 * @member {FileReader} #_reader
		 */
		this._reader = reader;

		this._data = undefined;

		/**
		 * Number of bytes loaded.
		 *
		 * @readonly
		 * @observable
		 * @member {Number} #loaded
		 */
		this.set( 'loaded', 0 );

		reader.onprogress = evt => {
			this.loaded = evt.loaded;
		};
	}

	/**
	 * Returns error that occurred during file reading.
	 *
	 * @returns {Error}
	 */
	get error() {
		return this._reader.error;
	}

	/**
	 * Holds the data of an already loaded file. The file must be first loaded
	 * by using {@link module:upload/filereader~FileReader#read `read()`}.
	 *
	 * @type {File|undefined}
	 */
	get data() {
		return this._data;
	}

	/**
	 * Reads the provided file.
	 *
	 * @param {File} file Native File object.
	 * @returns {Promise.<String>} Returns a promise that will be resolved with file's content.
	 * The promise will be rejected in case of an error or when the reading process is aborted.
	 */
	read( file ) {
		const reader = this._reader;
		this.total = file.size;

		return new Promise( ( resolve, reject ) => {
			reader.onload = () => {
				const result = reader.result;

				this._data = result;

				resolve( result );
			};

			reader.onerror = () => {
				reject( 'error' );
			};

			reader.onabort = () => {
				reject( 'aborted' );
			};

			this._reader.readAsDataURL( file );
		} );
	}

	/**
	 * Aborts file reader.
	 */
	abort() {
		this._reader.abort();
	}
}

(0,_ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_1__.default)( FileReader, _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_0__.default );


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-upload/src/filerepository.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-upload/src/filerepository.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ FileRepository)
/* harmony export */ });
/* harmony import */ var _ckeditor_ckeditor5_core_src_plugin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @ckeditor/ckeditor5-core/src/plugin */ "./node_modules/@ckeditor/ckeditor5-core/src/plugin.js");
/* harmony import */ var _ckeditor_ckeditor5_core_src_pendingactions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @ckeditor/ckeditor5-core/src/pendingactions */ "./node_modules/@ckeditor/ckeditor5-core/src/pendingactions.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/observablemixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_collection__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/collection */ "./node_modules/@ckeditor/ckeditor5-utils/src/collection.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/mix */ "./node_modules/@ckeditor/ckeditor5-utils/src/mix.js");
/* harmony import */ var _filereader_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./filereader.js */ "./node_modules/@ckeditor/ckeditor5-upload/src/filereader.js");
/* harmony import */ var _ckeditor_ckeditor5_utils_src_uid_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @ckeditor/ckeditor5-utils/src/uid.js */ "./node_modules/@ckeditor/ckeditor5-utils/src/uid.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module upload/filerepository
 */













/**
 * File repository plugin. A central point for managing file upload.
 *
 * To use it, first you need an upload adapter. Upload adapter's job is to handle communication with the server
 * (sending the file and handling server's response). You can use one of the existing plugins introducing upload adapters
 * (e.g. {@link module:easy-image/cloudservicesuploadadapter~CloudServicesUploadAdapter} or
 * {@link module:adapter-ckfinder/uploadadapter~CKFinderUploadAdapter}) or write your own one – see
 * the {@glink framework/guides/deep-dive/upload-adapter Custom image upload adapter deep dive guide}.
 *
 * Then, you can use {@link module:upload/filerepository~FileRepository#createLoader `createLoader()`} and the returned
 * {@link module:upload/filerepository~FileLoader} instance to load and upload files.
 *
 * @extends module:core/plugin~Plugin
 */
class FileRepository extends _ckeditor_ckeditor5_core_src_plugin__WEBPACK_IMPORTED_MODULE_0__.default {
	/**
	 * @inheritDoc
	 */
	static get pluginName() {
		return 'FileRepository';
	}

	/**
	 * @inheritDoc
	 */
	static get requires() {
		return [ _ckeditor_ckeditor5_core_src_pendingactions__WEBPACK_IMPORTED_MODULE_1__.default ];
	}

	/**
	 * @inheritDoc
	 */
	init() {
		/**
		 * Collection of loaders associated with this repository.
		 *
		 * @member {module:utils/collection~Collection} #loaders
		 */
		this.loaders = new _ckeditor_ckeditor5_utils_src_collection__WEBPACK_IMPORTED_MODULE_4__.default();

		// Keeps upload in a sync with pending actions.
		this.loaders.on( 'add', () => this._updatePendingAction() );
		this.loaders.on( 'remove', () => this._updatePendingAction() );

		/**
		 * Loaders mappings used to retrieve loaders references.
		 *
		 * @private
		 * @member {Map<File|Promise, FileLoader>} #_loadersMap
		 */
		this._loadersMap = new Map();

		/**
		 * Reference to a pending action registered in a {@link module:core/pendingactions~PendingActions} plugin
		 * while upload is in progress. When there is no upload then value is `null`.
		 *
		 * @private
		 * @member {Object} #_pendingAction
		 */
		this._pendingAction = null;

		/**
		 * A factory function which should be defined before using `FileRepository`.
		 *
		 * It should return a new instance of {@link module:upload/filerepository~UploadAdapter} that will be used to upload files.
		 * {@link module:upload/filerepository~FileLoader} instance associated with the adapter
		 * will be passed to that function.
		 *
		 * For more information and example see {@link module:upload/filerepository~UploadAdapter}.
		 *
		 * @member {Function} #createUploadAdapter
		 */

		/**
		 * Number of bytes uploaded.
		 *
		 * @readonly
		 * @observable
		 * @member {Number} #uploaded
		 */
		this.set( 'uploaded', 0 );

		/**
		 * Number of total bytes to upload.
		 *
		 * It might be different than the file size because of headers and additional data.
		 * It contains `null` if value is not available yet, so it's better to use {@link #uploadedPercent} to monitor
		 * the progress.
		 *
		 * @readonly
		 * @observable
		 * @member {Number|null} #uploadTotal
		 */
		this.set( 'uploadTotal', null );

		/**
		 * Upload progress in percents.
		 *
		 * @readonly
		 * @observable
		 * @member {Number} #uploadedPercent
		 */
		this.bind( 'uploadedPercent' ).to( this, 'uploaded', this, 'uploadTotal', ( uploaded, total ) => {
			return total ? ( uploaded / total * 100 ) : 0;
		} );
	}

	/**
	 * Returns the loader associated with specified file or promise.
	 *
	 * To get loader by id use `fileRepository.loaders.get( id )`.
	 *
	 * @param {File|Promise.<File>} fileOrPromise Native file or promise handle.
	 * @returns {module:upload/filerepository~FileLoader|null}
	 */
	getLoader( fileOrPromise ) {
		return this._loadersMap.get( fileOrPromise ) || null;
	}

	/**
	 * Creates a loader instance for the given file.
	 *
	 * Requires {@link #createUploadAdapter} factory to be defined.
	 *
	 * @param {File|Promise.<File>} fileOrPromise Native File object or native Promise object which resolves to a File.
	 * @returns {module:upload/filerepository~FileLoader|null}
	 */
	createLoader( fileOrPromise ) {
		if ( !this.createUploadAdapter ) {
			/**
			 * You need to enable an upload adapter in order to be able to upload files.
			 *
			 * This warning shows up when {@link module:upload/filerepository~FileRepository} is being used
			 * without {@link #createUploadAdapter defining an upload adapter}.
			 *
			 * **If you see this warning when using one of the {@glink builds/index CKEditor 5 Builds}**
			 * it means that you did not configure any of the upload adapters available by default in those builds.
			 *
			 * See the {@glink features/images/image-upload/image-upload comprehensive "Image upload overview"} to learn which upload
			 * adapters are available in the builds and how to configure them.
			 *
			 * **If you see this warning when using a custom build** there is a chance that you enabled
			 * a feature like {@link module:image/imageupload~ImageUpload},
			 * or {@link module:image/imageupload/imageuploadui~ImageUploadUI} but you did not enable any upload adapter.
			 * You can choose one of the existing upload adapters listed in the
			 * {@glink features/images/image-upload/image-upload "Image upload overview"}.
			 *
			 * You can also implement your {@glink framework/guides/deep-dive/upload-adapter own image upload adapter}.
			 *
			 * @error filerepository-no-upload-adapter
			 */
			(0,_ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_2__.logWarning)( 'filerepository-no-upload-adapter' );

			return null;
		}

		const loader = new FileLoader( Promise.resolve( fileOrPromise ), this.createUploadAdapter );

		this.loaders.add( loader );
		this._loadersMap.set( fileOrPromise, loader );

		// Store also file => loader mapping so loader can be retrieved by file instance returned upon Promise resolution.
		if ( fileOrPromise instanceof Promise ) {
			loader.file
				.then( file => {
					this._loadersMap.set( file, loader );
				} )
				// Every then() must have a catch().
				// File loader state (and rejections) are handled in read() and upload().
				// Also, see the "does not swallow the file promise rejection" test.
				.catch( () => {} );
		}

		loader.on( 'change:uploaded', () => {
			let aggregatedUploaded = 0;

			for ( const loader of this.loaders ) {
				aggregatedUploaded += loader.uploaded;
			}

			this.uploaded = aggregatedUploaded;
		} );

		loader.on( 'change:uploadTotal', () => {
			let aggregatedTotal = 0;

			for ( const loader of this.loaders ) {
				if ( loader.uploadTotal ) {
					aggregatedTotal += loader.uploadTotal;
				}
			}

			this.uploadTotal = aggregatedTotal;
		} );

		return loader;
	}

	/**
	 * Destroys the given loader.
	 *
	 * @param {File|Promise|module:upload/filerepository~FileLoader} fileOrPromiseOrLoader File or Promise associated
	 * with that loader or loader itself.
	 */
	destroyLoader( fileOrPromiseOrLoader ) {
		const loader = fileOrPromiseOrLoader instanceof FileLoader ? fileOrPromiseOrLoader : this.getLoader( fileOrPromiseOrLoader );

		loader._destroy();

		this.loaders.remove( loader );

		this._loadersMap.forEach( ( value, key ) => {
			if ( value === loader ) {
				this._loadersMap.delete( key );
			}
		} );
	}

	/**
	 * Registers or deregisters pending action bound with upload progress.
	 *
	 * @private
	 */
	_updatePendingAction() {
		const pendingActions = this.editor.plugins.get( _ckeditor_ckeditor5_core_src_pendingactions__WEBPACK_IMPORTED_MODULE_1__.default );

		if ( this.loaders.length ) {
			if ( !this._pendingAction ) {
				const t = this.editor.t;
				const getMessage = value => `${ t( 'Upload in progress' ) } ${ parseInt( value ) }%.`;

				this._pendingAction = pendingActions.add( getMessage( this.uploadedPercent ) );
				this._pendingAction.bind( 'message' ).to( this, 'uploadedPercent', getMessage );
			}
		} else {
			pendingActions.remove( this._pendingAction );
			this._pendingAction = null;
		}
	}
}

(0,_ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_5__.default)( FileRepository, _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_3__.default );

/**
 * File loader class.
 *
 * It is used to control the process of reading the file and uploading it using the specified upload adapter.
 */
class FileLoader {
	/**
	 * Creates a new instance of `FileLoader`.
	 *
	 * @param {Promise.<File>} filePromise A promise which resolves to a file instance.
	 * @param {Function} uploadAdapterCreator The function which returns {@link module:upload/filerepository~UploadAdapter} instance.
	 */
	constructor( filePromise, uploadAdapterCreator ) {
		/**
		 * Unique id of FileLoader instance.
		 *
		 * @readonly
		 * @member {Number}
		 */
		this.id = (0,_ckeditor_ckeditor5_utils_src_uid_js__WEBPACK_IMPORTED_MODULE_7__.default)();

		/**
		 * Additional wrapper over the initial file promise passed to this loader.
		 *
		 * @protected
		 * @member {module:upload/filerepository~FilePromiseWrapper}
		 */
		this._filePromiseWrapper = this._createFilePromiseWrapper( filePromise );

		/**
		 * Adapter instance associated with this file loader.
		 *
		 * @private
		 * @member {module:upload/filerepository~UploadAdapter}
		 */
		this._adapter = uploadAdapterCreator( this );

		/**
		 * FileReader used by FileLoader.
		 *
		 * @protected
		 * @member {module:upload/filereader~FileReader}
		 */
		this._reader = new _filereader_js__WEBPACK_IMPORTED_MODULE_6__.default();

		/**
		 * Current status of FileLoader. It can be one of the following:
		 *
		 * * 'idle',
		 * * 'reading',
		 * * 'uploading',
		 * * 'aborted',
		 * * 'error'.
		 *
		 * When reading status can change in a following way:
		 *
		 * `idle` -> `reading` -> `idle`
		 * `idle` -> `reading -> `aborted`
		 * `idle` -> `reading -> `error`
		 *
		 * When uploading status can change in a following way:
		 *
		 * `idle` -> `uploading` -> `idle`
		 * `idle` -> `uploading` -> `aborted`
		 * `idle` -> `uploading` -> `error`
		 *
		 * @readonly
		 * @observable
		 * @member {String} #status
		 */
		this.set( 'status', 'idle' );

		/**
		 * Number of bytes uploaded.
		 *
		 * @readonly
		 * @observable
		 * @member {Number} #uploaded
		 */
		this.set( 'uploaded', 0 );

		/**
		 * Number of total bytes to upload.
		 *
		 * @readonly
		 * @observable
		 * @member {Number|null} #uploadTotal
		 */
		this.set( 'uploadTotal', null );

		/**
		 * Upload progress in percents.
		 *
		 * @readonly
		 * @observable
		 * @member {Number} #uploadedPercent
		 */
		this.bind( 'uploadedPercent' ).to( this, 'uploaded', this, 'uploadTotal', ( uploaded, total ) => {
			return total ? ( uploaded / total * 100 ) : 0;
		} );

		/**
		 * Response of the upload.
		 *
		 * @readonly
		 * @observable
		 * @member {Object|null} #uploadResponse
		 */
		this.set( 'uploadResponse', null );
	}

	/**
	 * A `Promise` which resolves to a `File` instance associated with this file loader.
	 *
	 * @type {Promise.<File|null>}
	 */
	get file() {
		if ( !this._filePromiseWrapper ) {
			// Loader was destroyed, return promise which resolves to null.
			return Promise.resolve( null );
		} else {
			// The `this._filePromiseWrapper.promise` is chained and not simply returned to handle a case when:
			//
			//		* The `loader.file.then( ... )` is called by external code (returned promise is pending).
			//		* Then `loader._destroy()` is called (call is synchronous) which destroys the `loader`.
			//		* Promise returned by the first `loader.file.then( ... )` call is resolved.
			//
			// Returning `this._filePromiseWrapper.promise` will still resolve to a `File` instance so there
			// is an additional check needed in the chain to see if `loader` was destroyed in the meantime.
			return this._filePromiseWrapper.promise.then( file => this._filePromiseWrapper ? file : null );
		}
	}

	/**
	 * Returns the file data. To read its data, you need for first load the file
	 * by using the {@link module:upload/filerepository~FileLoader#read `read()`} method.
	 *
	 * @type {File|undefined}
	 */
	get data() {
		return this._reader.data;
	}

	/**
	 * Reads file using {@link module:upload/filereader~FileReader}.
	 *
	 * Throws {@link module:utils/ckeditorerror~CKEditorError CKEditorError} `filerepository-read-wrong-status` when status
	 * is different than `idle`.
	 *
	 * Example usage:
	 *
	 *	fileLoader.read()
	 *		.then( data => { ... } )
	 *		.catch( err => {
	 *			if ( err === 'aborted' ) {
	 *				console.log( 'Reading aborted.' );
	 *			} else {
	 *				console.log( 'Reading error.', err );
	 *			}
	 *		} );
	 *
	 * @returns {Promise.<String>} Returns promise that will be resolved with read data. Promise will be rejected if error
	 * occurs or if read process is aborted.
	 */
	read() {
		if ( this.status != 'idle' ) {
			/**
			 * You cannot call read if the status is different than idle.
			 *
			 * @error filerepository-read-wrong-status
			 */
			throw new _ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_2__.default( 'filerepository-read-wrong-status', this );
		}

		this.status = 'reading';

		return this.file
			.then( file => this._reader.read( file ) )
			.then( data => {
				// Edge case: reader was aborted after file was read - double check for proper status.
				// It can happen when image was deleted during its upload.
				if ( this.status !== 'reading' ) {
					throw this.status;
				}

				this.status = 'idle';

				return data;
			} )
			.catch( err => {
				if ( err === 'aborted' ) {
					this.status = 'aborted';
					throw 'aborted';
				}

				this.status = 'error';
				throw this._reader.error ? this._reader.error : err;
			} );
	}

	/**
	 * Reads file using the provided {@link module:upload/filerepository~UploadAdapter}.
	 *
	 * Throws {@link module:utils/ckeditorerror~CKEditorError CKEditorError} `filerepository-upload-wrong-status` when status
	 * is different than `idle`.
	 * Example usage:
	 *
	 *	fileLoader.upload()
	 *		.then( data => { ... } )
	 *		.catch( e => {
	 *			if ( e === 'aborted' ) {
	 *				console.log( 'Uploading aborted.' );
	 *			} else {
	 *				console.log( 'Uploading error.', e );
	 *			}
	 *		} );
	 *
	 * @returns {Promise.<Object>} Returns promise that will be resolved with response data. Promise will be rejected if error
	 * occurs or if read process is aborted.
	 */
	upload() {
		if ( this.status != 'idle' ) {
			/**
			 * You cannot call upload if the status is different than idle.
			 *
			 * @error filerepository-upload-wrong-status
			 */
			throw new _ckeditor_ckeditor5_utils_src_ckeditorerror__WEBPACK_IMPORTED_MODULE_2__.default( 'filerepository-upload-wrong-status', this );
		}

		this.status = 'uploading';

		return this.file
			.then( () => this._adapter.upload() )
			.then( data => {
				this.uploadResponse = data;
				this.status = 'idle';

				return data;
			} )
			.catch( err => {
				if ( this.status === 'aborted' ) {
					throw 'aborted';
				}

				this.status = 'error';
				throw err;
			} );
	}

	/**
	 * Aborts loading process.
	 */
	abort() {
		const status = this.status;
		this.status = 'aborted';

		if ( !this._filePromiseWrapper.isFulfilled ) {
			// Edge case: file loader is aborted before read() is called
			// so it might happen that no one handled the rejection of this promise.
			// See https://github.com/ckeditor/ckeditor5-upload/pull/100
			this._filePromiseWrapper.promise.catch( () => {} );

			this._filePromiseWrapper.rejecter( 'aborted' );
		} else if ( status == 'reading' ) {
			this._reader.abort();
		} else if ( status == 'uploading' && this._adapter.abort ) {
			this._adapter.abort();
		}

		this._destroy();
	}

	/**
	 * Performs cleanup.
	 *
	 * @private
	 */
	_destroy() {
		this._filePromiseWrapper = undefined;
		this._reader = undefined;
		this._adapter = undefined;
		this.uploadResponse = undefined;
	}

	/**
	 * Wraps a given file promise into another promise giving additional
	 * control (resolving, rejecting, checking if fulfilled) over it.
	 *
	 * @private
	 * @param filePromise The initial file promise to be wrapped.
	 * @returns {module:upload/filerepository~FilePromiseWrapper}
	 */
	_createFilePromiseWrapper( filePromise ) {
		const wrapper = {};

		wrapper.promise = new Promise( ( resolve, reject ) => {
			wrapper.rejecter = reject;
			wrapper.isFulfilled = false;

			filePromise
				.then( file => {
					wrapper.isFulfilled = true;
					resolve( file );
				} )
				.catch( err => {
					wrapper.isFulfilled = true;
					reject( err );
				} );
		} );

		return wrapper;
	}
}

(0,_ckeditor_ckeditor5_utils_src_mix__WEBPACK_IMPORTED_MODULE_5__.default)( FileLoader, _ckeditor_ckeditor5_utils_src_observablemixin__WEBPACK_IMPORTED_MODULE_3__.default );

/**
 * Upload adapter interface used by the {@link module:upload/filerepository~FileRepository file repository}
 * to handle file upload. An upload adapter is a bridge between the editor and server that handles file uploads.
 * It should contain a logic necessary to initiate an upload process and monitor its progress.
 *
 * Learn how to develop your own upload adapter for CKEditor 5 in the
 * {@glink framework/guides/deep-dive/upload-adapter "Custom upload adapter" guide}.
 *
 * @interface UploadAdapter
 */

/**
 * Executes the upload process.
 * This method should return a promise that will resolve when data will be uploaded to server. Promise should be
 * resolved with an object containing information about uploaded file:
 *
 *		{
 *			default: 'http://server/default-size.image.png'
 *		}
 *
 * Additionally, other image sizes can be provided:
 *
 *		{
 *			default: 'http://server/default-size.image.png',
 *			'160': 'http://server/size-160.image.png',
 *			'500': 'http://server/size-500.image.png',
 *			'1000': 'http://server/size-1000.image.png',
 *			'1052': 'http://server/default-size.image.png'
 *		}
 *
 * You can also pass additional properties from the server. In this case you need to wrap URLs
 * in the `urls` object and pass additional properties along the `urls` property.
 *
 * 		{
 * 			myCustomProperty: 'foo',
 * 			urls: {
 *				default: 'http://server/default-size.image.png',
 *				'160': 'http://server/size-160.image.png',
 *				'500': 'http://server/size-500.image.png',
 *				'1000': 'http://server/size-1000.image.png',
 *				'1052': 'http://server/default-size.image.png'
 *			}
 *		}
 *
 * NOTE: When returning multiple images, the widest returned one should equal the default one. It is essential to
 * correctly set `width` attribute of the image. See this discussion:
 * https://github.com/ckeditor/ckeditor5-easy-image/issues/4 for more information.
 *
 * Take a look at {@link module:upload/filerepository~UploadAdapter example Adapter implementation} and
 * {@link module:upload/filerepository~FileRepository#createUploadAdapter createUploadAdapter method}.
 *
 * @method module:upload/filerepository~UploadAdapter#upload
 * @returns {Promise.<Object>} Promise that should be resolved when data is uploaded.
 */

/**
 * Aborts the upload process.
 * After aborting it should reject promise returned from {@link #upload upload()}.
 *
 * Take a look at {@link module:upload/filerepository~UploadAdapter example Adapter implementation} and
 * {@link module:upload/filerepository~FileRepository#createUploadAdapter createUploadAdapter method}.
 *
 * @method module:upload/filerepository~UploadAdapter#abort
 */

/**
 * Object returned by {@link module:upload/filerepository~FileLoader#_createFilePromiseWrapper} method
 * to add more control over the initial file promise passed to {@link module:upload/filerepository~FileLoader}.
 *
 * @protected
 * @typedef {Object} module:upload/filerepository~FilePromiseWrapper
 * @property {Promise.<File>} promise Wrapper promise which can be chained for further processing.
 * @property {Function} rejecter Rejects the promise when called.
 * @property {Boolean} isFulfilled Whether original promise is already fulfilled.
 */


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DOCUMENTATION_URL": () => (/* binding */ DOCUMENTATION_URL),
/* harmony export */   "default": () => (/* binding */ CKEditorError),
/* harmony export */   "logWarning": () => (/* binding */ logWarning),
/* harmony export */   "logError": () => (/* binding */ logError)
/* harmony export */ });
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/ckeditorerror
 */

/* globals console */

/**
 * URL to the documentation with error codes.
 */
const DOCUMENTATION_URL =
	'https://ckeditor.com/docs/ckeditor5/latest/framework/guides/support/error-codes.html';

/**
 * The CKEditor error class.
 *
 * You should throw `CKEditorError` when:
 *
 * * An unexpected situation occurred and the editor (most probably) will not work properly. Such exception will be handled
 * by the {@link module:watchdog/watchdog~Watchdog watchdog} (if it is integrated),
 * * If the editor is incorrectly integrated or the editor API is used in the wrong way. This way you will give
 * feedback to the developer as soon as possible. Keep in mind that for common integration issues which should not
 * stop editor initialization (like missing upload adapter, wrong name of a toolbar component) we use
 * {@link module:utils/ckeditorerror~logWarning `logWarning()`} and
 * {@link module:utils/ckeditorerror~logError `logError()`}
 * to improve developers experience and let them see the a working editor as soon as possible.
 *
 *		/**
 *		 * Error thrown when a plugin cannot be loaded due to JavaScript errors, lack of plugins with a given name, etc.
 *		 *
 *		 * @error plugin-load
 *		 * @param pluginName The name of the plugin that could not be loaded.
 *		 * @param moduleName The name of the module which tried to load this plugin.
 *		 * /
 *		throw new CKEditorError( 'plugin-load', {
 *			pluginName: 'foo',
 *			moduleName: 'bar'
 *		} );
 *
 * @extends Error
 */
class CKEditorError extends Error {
	/**
	 * Creates an instance of the CKEditorError class.
	 *
	 * @param {String} errorName The error id in an `error-name` format. A link to this error documentation page will be added
	 * to the thrown error's `message`.
	 * @param {Object|null} context A context of the error by which the {@link module:watchdog/watchdog~Watchdog watchdog}
	 * is able to determine which editor crashed. It should be an editor instance or a property connected to it. It can be also
	 * a `null` value if the editor should not be restarted in case of the error (e.g. during the editor initialization).
	 * The error context should be checked using the `areConnectedThroughProperties( editor, context )` utility
	 * to check if the object works as the context.
	 * @param {Object} [data] Additional data describing the error. A stringified version of this object
	 * will be appended to the error message, so the data are quickly visible in the console. The original
	 * data object will also be later available under the {@link #data} property.
	 */
	constructor( errorName, context, data ) {
		const message = `${ errorName }${ ( data ? ` ${ JSON.stringify( data ) }` : '' ) }${ getLinkToDocumentationMessage( errorName ) }`;

		super( message );

		/**
		 * @type {String}
		 */
		this.name = 'CKEditorError';

		/**
		 * A context of the error by which the Watchdog is able to determine which editor crashed.
		 *
		 * @type {Object|null}
		 */
		this.context = context;

		/**
		 * The additional error data passed to the constructor. Undefined if none was passed.
		 *
		 * @type {Object|undefined}
		 */
		this.data = data;
	}

	/**
	 * Checks if the error is of the `CKEditorError` type.
	 */
	is( type ) {
		return type === 'CKEditorError';
	}

	/**
	 * A utility that ensures that the thrown error is a {@link module:utils/ckeditorerror~CKEditorError} one.
	 * It is useful when combined with the {@link module:watchdog/watchdog~Watchdog} feature, which can restart the editor in case
	 * of a {@link module:utils/ckeditorerror~CKEditorError} error.
	 *
	 * @static
	 * @param {Error} err The error to rethrow.
	 * @param {Object} context An object connected through properties with the editor instance. This context will be used
	 * by the watchdog to verify which editor should be restarted.
	 */
	static rethrowUnexpectedError( err, context ) {
		if ( err.is && err.is( 'CKEditorError' ) ) {
			throw err;
		}

		/**
		 * An unexpected error occurred inside the CKEditor 5 codebase. This error will look like the original one
		 * to make the debugging easier.
		 *
		 * This error is only useful when the editor is initialized using the {@link module:watchdog/watchdog~Watchdog} feature.
		 * In case of such error (or any {@link module:utils/ckeditorerror~CKEditorError} error) the watchdog should restart the editor.
		 *
		 * @error unexpected-error
		 */
		const error = new CKEditorError( err.message, context );

		// Restore the original stack trace to make the error look like the original one.
		// See https://github.com/ckeditor/ckeditor5/issues/5595 for more details.
		error.stack = err.stack;

		throw error;
	}
}

/**
 * Logs a warning to the console with a properly formatted message and adds a link to the documentation.
 * Use whenever you want to log a warning to the console.
 *
 *		/**
 *		 * There was a problem processing the configuration of the toolbar. The item with the given
 *		 * name does not exist, so it was omitted when rendering the toolbar.
 *		 *
 *		 * @error toolbarview-item-unavailable
 *		 * @param {String} name The name of the component.
 *		 * /
 *		logWarning( 'toolbarview-item-unavailable', { name } );
 *
 * See also {@link module:utils/ckeditorerror~CKEditorError} for an explanation when to throw an error and when to log
 * a warning or an error to the console.
 *
 * @param {String} errorName The error name to be logged.
 * @param {Object} [data] Additional data to be logged.
 * @returns {String}
 */
function logWarning( errorName, data ) {
	console.warn( ...formatConsoleArguments( errorName, data ) );
}

/**
 * Logs an error to the console with a properly formatted message and adds a link to the documentation.
 * Use whenever you want to log an error to the console.
 *
 *		/**
 *		 * There was a problem processing the configuration of the toolbar. The item with the given
 *		 * name does not exist, so it was omitted when rendering the toolbar.
 *		 *
 *		 * @error toolbarview-item-unavailable
 *		 * @param {String} name The name of the component.
 *		 * /
 *		 logError( 'toolbarview-item-unavailable', { name } );
 *
 * **Note**: In most cases logging a warning using {@link module:utils/ckeditorerror~logWarning} is enough.
 *
 * See also {@link module:utils/ckeditorerror~CKEditorError} for an explanation when to use each method.
 *
 * @param {String} errorName The error name to be logged.
 * @param {Object} [data] Additional data to be logged.
 * @returns {String}
 */
function logError( errorName, data ) {
	console.error( ...formatConsoleArguments( errorName, data ) );
}

function getLinkToDocumentationMessage( errorName ) {
	return `\nRead more: ${ DOCUMENTATION_URL }#error-${ errorName }`;
}

function formatConsoleArguments( errorName, data ) {
	const documentationMessage = getLinkToDocumentationMessage( errorName );

	return data ? [ errorName, data, documentationMessage ] : [ errorName, documentationMessage ];
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/collection.js":
/*!******************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/collection.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Collection)
/* harmony export */ });
/* harmony import */ var _emittermixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./emittermixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/emittermixin.js");
/* harmony import */ var _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/* harmony import */ var _uid__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./uid */ "./node_modules/@ckeditor/ckeditor5-utils/src/uid.js");
/* harmony import */ var _isiterable__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./isiterable */ "./node_modules/@ckeditor/ckeditor5-utils/src/isiterable.js");
/* harmony import */ var _mix__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./mix */ "./node_modules/@ckeditor/ckeditor5-utils/src/mix.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/collection
 */







/**
 * Collections are ordered sets of objects. Items in the collection can be retrieved by their indexes
 * in the collection (like in an array) or by their ids.
 *
 * If an object without an `id` property is being added to the collection, the `id` property will be generated
 * automatically. Note that the automatically generated id is unique only within this single collection instance.
 *
 * By default an item in the collection is identified by its `id` property. The name of the identifier can be
 * configured through the constructor of the collection.
 *
 * @mixes module:utils/emittermixin~EmitterMixin
 */
class Collection {
	/**
	 * Creates a new Collection instance.
	 *
	 * You can provide an iterable of initial items the collection will be created with:
	 *
	 *		const collection = new Collection( [ { id: 'John' }, { id: 'Mike' } ] );
	 *
	 *		console.log( collection.get( 0 ) ); // -> { id: 'John' }
	 *		console.log( collection.get( 1 ) ); // -> { id: 'Mike' }
	 *		console.log( collection.get( 'Mike' ) ); // -> { id: 'Mike' }
	 *
	 * Or you can first create a collection and then add new items using the {@link #add} method:
	 *
	 *		const collection = new Collection();
	 *
	 *		collection.add( { id: 'John' } );
	 *		console.log( collection.get( 0 ) ); // -> { id: 'John' }
	 *
	 * Whatever option you choose, you can always pass a configuration object as the last argument
	 * of the constructor:
	 *
	 *		const emptyCollection = new Collection( { idProperty: 'name' } );
	 *		emptyCollection.add( { name: 'John' } );
	 *		console.log( collection.get( 'John' ) ); // -> { name: 'John' }
	 *
	 *		const nonEmptyCollection = new Collection( [ { name: 'John' } ], { idProperty: 'name' } );
	 *		nonEmptyCollection.add( { name: 'George' } );
	 *		console.log( collection.get( 'George' ) ); // -> { name: 'George' }
	 *		console.log( collection.get( 'John' ) ); // -> { name: 'John' }
	 *
	 * @param {Iterable.<Object>|Object} initialItemsOrOptions The initial items of the collection or
	 * the options object.
	 * @param {Object} [options={}] The options object, when the first argument is an array of initial items.
	 * @param {String} [options.idProperty='id'] The name of the property which is used to identify an item.
	 * Items that do not have such a property will be assigned one when added to the collection.
	 */
	constructor( initialItemsOrOptions = {}, options = {} ) {
		const hasInitialItems = (0,_isiterable__WEBPACK_IMPORTED_MODULE_3__.default)( initialItemsOrOptions );

		if ( !hasInitialItems ) {
			options = initialItemsOrOptions;
		}

		/**
		 * The internal list of items in the collection.
		 *
		 * @private
		 * @member {Object[]}
		 */
		this._items = [];

		/**
		 * The internal map of items in the collection.
		 *
		 * @private
		 * @member {Map}
		 */
		this._itemMap = new Map();

		/**
		 * The name of the property which is considered to identify an item.
		 *
		 * @private
		 * @member {String}
		 */
		this._idProperty = options.idProperty || 'id';

		/**
		 * A helper mapping external items of a bound collection ({@link #bindTo})
		 * and actual items of this collection. It provides information
		 * necessary to properly remove items bound to another collection.
		 *
		 * See {@link #_bindToInternalToExternalMap}.
		 *
		 * @protected
		 * @member {WeakMap}
		 */
		this._bindToExternalToInternalMap = new WeakMap();

		/**
		 * A helper mapping items of this collection to external items of a bound collection
		 * ({@link #bindTo}). It provides information necessary to manage the bindings, e.g.
		 * to avoid loops in two–way bindings.
		 *
		 * See {@link #_bindToExternalToInternalMap}.
		 *
		 * @protected
		 * @member {WeakMap}
		 */
		this._bindToInternalToExternalMap = new WeakMap();

		/**
		 * Stores indexes of skipped items from bound external collection.
		 *
		 * @private
		 * @member {Array}
		 */
		this._skippedIndexesFromExternal = [];

		// Set the initial content of the collection (if provided in the constructor).
		if ( hasInitialItems ) {
			for ( const item of initialItemsOrOptions ) {
				this._items.push( item );
				this._itemMap.set( this._getItemIdBeforeAdding( item ), item );
			}
		}

		/**
		 * A collection instance this collection is bound to as a result
		 * of calling {@link #bindTo} method.
		 *
		 * @protected
		 * @member {module:utils/collection~Collection} #_bindToCollection
		 */
	}

	/**
	 * The number of items available in the collection.
	 *
	 * @member {Number} #length
	 */
	get length() {
		return this._items.length;
	}

	/**
	 * Returns the first item from the collection or null when collection is empty.
	 *
	 * @returns {Object|null} The first item or `null` if collection is empty.
	 */
	get first() {
		return this._items[ 0 ] || null;
	}

	/**
	 * Returns the last item from the collection or null when collection is empty.
	 *
	 * @returns {Object|null} The last item or `null` if collection is empty.
	 */
	get last() {
		return this._items[ this.length - 1 ] || null;
	}

	/**
	 * Adds an item into the collection.
	 *
	 * If the item does not have an id, then it will be automatically generated and set on the item.
	 *
	 * @chainable
	 * @param {Object} item
	 * @param {Number} [index] The position of the item in the collection. The item
	 * is pushed to the collection when `index` not specified.
	 * @fires add
	 * @fires change
	 */
	add( item, index ) {
		return this.addMany( [ item ], index );
	}

	/**
	 * Adds multiple items into the collection.
	 *
	 * Any item not containing an id will get an automatically generated one.
	 *
	 * @chainable
	 * @param {Iterable.<Object>} item
	 * @param {Number} [index] The position of the insertion. Items will be appended if no `index` is specified.
	 * @fires add
	 * @fires change
	 */
	addMany( items, index ) {
		if ( index === undefined ) {
			index = this._items.length;
		} else if ( index > this._items.length || index < 0 ) {
			/**
			 * The `index` passed to {@link module:utils/collection~Collection#addMany `Collection#addMany()`}
			 * is invalid. It must be a number between 0 and the collection's length.
			 *
			 * @error collection-add-item-invalid-index
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'collection-add-item-invalid-index', this );
		}

		for ( let offset = 0; offset < items.length; offset++ ) {
			const item = items[ offset ];
			const itemId = this._getItemIdBeforeAdding( item );
			const currentItemIndex = index + offset;

			this._items.splice( currentItemIndex, 0, item );
			this._itemMap.set( itemId, item );

			this.fire( 'add', item, currentItemIndex );
		}

		this.fire( 'change', {
			added: items,
			removed: [],
			index
		} );

		return this;
	}

	/**
	 * Gets an item by its ID or index.
	 *
	 * @param {String|Number} idOrIndex The item ID or index in the collection.
	 * @returns {Object|null} The requested item or `null` if such item does not exist.
	 */
	get( idOrIndex ) {
		let item;

		if ( typeof idOrIndex == 'string' ) {
			item = this._itemMap.get( idOrIndex );
		} else if ( typeof idOrIndex == 'number' ) {
			item = this._items[ idOrIndex ];
		} else {
			/**
			 * An index or ID must be given.
			 *
			 * @error collection-get-invalid-arg
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'collection-get-invalid-arg', this );
		}

		return item || null;
	}

	/**
	 * Returns a Boolean indicating whether the collection contains an item.
	 *
	 * @param {Object|String} itemOrId The item or its ID in the collection.
	 * @returns {Boolean} `true` if the collection contains the item, `false` otherwise.
	 */
	has( itemOrId ) {
		if ( typeof itemOrId == 'string' ) {
			return this._itemMap.has( itemOrId );
		} else { // Object
			const idProperty = this._idProperty;
			const id = itemOrId[ idProperty ];

			return this._itemMap.has( id );
		}
	}

	/**
	 * Gets an index of an item in the collection.
	 * When an item is not defined in the collection, the index will equal -1.
	 *
	 * @param {Object|String} itemOrId The item or its ID in the collection.
	 * @returns {Number} The index of a given item.
	 */
	getIndex( itemOrId ) {
		let item;

		if ( typeof itemOrId == 'string' ) {
			item = this._itemMap.get( itemOrId );
		} else {
			item = itemOrId;
		}

		return this._items.indexOf( item );
	}

	/**
	 * Removes an item from the collection.
	 *
	 * @param {Object|Number|String} subject The item to remove, its ID or index in the collection.
	 * @returns {Object} The removed item.
	 * @fires remove
	 * @fires change
	 */
	remove( subject ) {
		const [ item, index ] = this._remove( subject );

		this.fire( 'change', {
			added: [],
			removed: [ item ],
			index
		} );

		return item;
	}

	/**
	 * Executes the callback for each item in the collection and composes an array or values returned by this callback.
	 *
	 * @param {Function} callback
	 * @param {Object} callback.item
	 * @param {Number} callback.index
	 * @param {Object} ctx Context in which the `callback` will be called.
	 * @returns {Array} The result of mapping.
	 */
	map( callback, ctx ) {
		return this._items.map( callback, ctx );
	}

	/**
	 * Finds the first item in the collection for which the `callback` returns a true value.
	 *
	 * @param {Function} callback
	 * @param {Object} callback.item
	 * @param {Number} callback.index
	 * @param {Object} ctx Context in which the `callback` will be called.
	 * @returns {Object} The item for which `callback` returned a true value.
	 */
	find( callback, ctx ) {
		return this._items.find( callback, ctx );
	}

	/**
	 * Returns an array with items for which the `callback` returned a true value.
	 *
	 * @param {Function} callback
	 * @param {Object} callback.item
	 * @param {Number} callback.index
	 * @param {Object} ctx Context in which the `callback` will be called.
	 * @returns {Object[]} The array with matching items.
	 */
	filter( callback, ctx ) {
		return this._items.filter( callback, ctx );
	}

	/**
	 * Removes all items from the collection and destroys the binding created using
	 * {@link #bindTo}.
	 *
	 * @fires remove
	 * @fires change
	 */
	clear() {
		if ( this._bindToCollection ) {
			this.stopListening( this._bindToCollection );
			this._bindToCollection = null;
		}

		const removedItems = Array.from( this._items );

		while ( this.length ) {
			this._remove( 0 );
		}

		this.fire( 'change', {
			added: [],
			removed: removedItems,
			index: 0
		} );
	}

	/**
	 * Binds and synchronizes the collection with another one.
	 *
	 * The binding can be a simple factory:
	 *
	 *		class FactoryClass {
	 *			constructor( data ) {
	 *				this.label = data.label;
	 *			}
	 *		}
	 *
	 *		const source = new Collection( { idProperty: 'label' } );
	 *		const target = new Collection();
	 *
	 *		target.bindTo( source ).as( FactoryClass );
	 *
	 *		source.add( { label: 'foo' } );
	 *		source.add( { label: 'bar' } );
	 *
	 *		console.log( target.length ); // 2
	 *		console.log( target.get( 1 ).label ); // 'bar'
	 *
	 *		source.remove( 0 );
	 *		console.log( target.length ); // 1
	 *		console.log( target.get( 0 ).label ); // 'bar'
	 *
	 * or the factory driven by a custom callback:
	 *
	 *		class FooClass {
	 *			constructor( data ) {
	 *				this.label = data.label;
	 *			}
	 *		}
	 *
	 *		class BarClass {
	 *			constructor( data ) {
	 *				this.label = data.label;
	 *			}
	 *		}
	 *
	 *		const source = new Collection( { idProperty: 'label' } );
	 *		const target = new Collection();
	 *
	 *		target.bindTo( source ).using( ( item ) => {
	 *			if ( item.label == 'foo' ) {
	 *				return new FooClass( item );
	 *			} else {
	 *				return new BarClass( item );
	 *			}
	 *		} );
	 *
	 *		source.add( { label: 'foo' } );
	 *		source.add( { label: 'bar' } );
	 *
	 *		console.log( target.length ); // 2
	 *		console.log( target.get( 0 ) instanceof FooClass ); // true
	 *		console.log( target.get( 1 ) instanceof BarClass ); // true
	 *
	 * or the factory out of property name:
	 *
	 *		const source = new Collection( { idProperty: 'label' } );
	 *		const target = new Collection();
	 *
	 *		target.bindTo( source ).using( 'label' );
	 *
	 *		source.add( { label: { value: 'foo' } } );
	 *		source.add( { label: { value: 'bar' } } );
	 *
	 *		console.log( target.length ); // 2
	 *		console.log( target.get( 0 ).value ); // 'foo'
	 *		console.log( target.get( 1 ).value ); // 'bar'
	 *
	 * It's possible to skip specified items by returning falsy value:
	 *
	 *		const source = new Collection();
	 *		const target = new Collection();
	 *
	 *		target.bindTo( source ).using( item => {
	 *			if ( item.hidden ) {
	 *				return null;
	 *			}
	 *
	 *			return item;
	 *		} );
	 *
	 *		source.add( { hidden: true } );
	 *		source.add( { hidden: false } );
	 *
	 *		console.log( source.length ); // 2
	 *		console.log( target.length ); // 1
	 *
	 * **Note**: {@link #clear} can be used to break the binding.
	 *
	 * @param {module:utils/collection~Collection} externalCollection A collection to be bound.
	 * @returns {Object}
	 * @returns {module:utils/collection~CollectionBindToChain} The binding chain object.
	 */
	bindTo( externalCollection ) {
		if ( this._bindToCollection ) {
			/**
			 * The collection cannot be bound more than once.
			 *
			 * @error collection-bind-to-rebind
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'collection-bind-to-rebind', this );
		}

		this._bindToCollection = externalCollection;

		return {
			as: Class => {
				this._setUpBindToBinding( item => new Class( item ) );
			},

			using: callbackOrProperty => {
				if ( typeof callbackOrProperty == 'function' ) {
					this._setUpBindToBinding( item => callbackOrProperty( item ) );
				} else {
					this._setUpBindToBinding( item => item[ callbackOrProperty ] );
				}
			}
		};
	}

	/**
	 * Finalizes and activates a binding initiated by {#bindTo}.
	 *
	 * @protected
	 * @param {Function} factory A function which produces collection items.
	 */
	_setUpBindToBinding( factory ) {
		const externalCollection = this._bindToCollection;

		// Adds the item to the collection once a change has been done to the external collection.
		//
		// @private
		const addItem = ( evt, externalItem, index ) => {
			const isExternalBoundToThis = externalCollection._bindToCollection == this;
			const externalItemBound = externalCollection._bindToInternalToExternalMap.get( externalItem );

			// If an external collection is bound to this collection, which makes it a 2–way binding,
			// and the particular external collection item is already bound, don't add it here.
			// The external item has been created **out of this collection's item** and (re)adding it will
			// cause a loop.
			if ( isExternalBoundToThis && externalItemBound ) {
				this._bindToExternalToInternalMap.set( externalItem, externalItemBound );
				this._bindToInternalToExternalMap.set( externalItemBound, externalItem );
			} else {
				const item = factory( externalItem );

				// When there is no item we need to remember skipped index first and then we can skip this item.
				if ( !item ) {
					this._skippedIndexesFromExternal.push( index );

					return;
				}

				// Lets try to put item at the same index as index in external collection
				// but when there are a skipped items in one or both collections we need to recalculate this index.
				let finalIndex = index;

				// When we try to insert item after some skipped items from external collection we need
				// to include this skipped items and decrease index.
				//
				// For the following example:
				// external -> [ 'A', 'B - skipped for internal', 'C - skipped for internal' ]
				// internal -> [ A ]
				//
				// Another item is been added at the end of external collection:
				// external.add( 'D' )
				// external -> [ 'A', 'B - skipped for internal', 'C - skipped for internal', 'D' ]
				//
				// We can't just add 'D' to internal at the same index as index in external because
				// this will produce empty indexes what is invalid:
				// internal -> [ 'A', empty, empty, 'D' ]
				//
				// So we need to include skipped items and decrease index
				// internal -> [ 'A', 'D' ]
				for ( const skipped of this._skippedIndexesFromExternal ) {
					if ( index > skipped ) {
						finalIndex--;
					}
				}

				// We need to take into consideration that external collection could skip some items from
				// internal collection.
				//
				// For the following example:
				// internal -> [ 'A', 'B - skipped for external', 'C - skipped for external' ]
				// external -> [ A ]
				//
				// Another item is been added at the end of external collection:
				// external.add( 'D' )
				// external -> [ 'A', 'D' ]
				//
				// We need to include skipped items and place new item after them:
				// internal -> [ 'A', 'B - skipped for external', 'C - skipped for external', 'D' ]
				for ( const skipped of externalCollection._skippedIndexesFromExternal ) {
					if ( finalIndex >= skipped ) {
						finalIndex++;
					}
				}

				this._bindToExternalToInternalMap.set( externalItem, item );
				this._bindToInternalToExternalMap.set( item, externalItem );
				this.add( item, finalIndex );

				// After adding new element to internal collection we need update indexes
				// of skipped items in external collection.
				for ( let i = 0; i < externalCollection._skippedIndexesFromExternal.length; i++ ) {
					if ( finalIndex <= externalCollection._skippedIndexesFromExternal[ i ] ) {
						externalCollection._skippedIndexesFromExternal[ i ]++;
					}
				}
			}
		};

		// Load the initial content of the collection.
		for ( const externalItem of externalCollection ) {
			addItem( null, externalItem, externalCollection.getIndex( externalItem ) );
		}

		// Synchronize the with collection as new items are added.
		this.listenTo( externalCollection, 'add', addItem );

		// Synchronize the with collection as new items are removed.
		this.listenTo( externalCollection, 'remove', ( evt, externalItem, index ) => {
			const item = this._bindToExternalToInternalMap.get( externalItem );

			if ( item ) {
				this.remove( item );
			}

			// After removing element from external collection we need update/remove indexes
			// of skipped items in internal collection.
			this._skippedIndexesFromExternal = this._skippedIndexesFromExternal.reduce( ( result, skipped ) => {
				if ( index < skipped ) {
					result.push( skipped - 1 );
				}

				if ( index > skipped ) {
					result.push( skipped );
				}

				return result;
			}, [] );
		} );
	}

	/**
	 * Returns an unique id property for a given `item`.
	 *
	 * The method will generate new id and assign it to the `item` if it doesn't have any.
	 *
	 * @private
	 * @param {Object} item Item to be added.
	 * @returns {String}
	 */
	_getItemIdBeforeAdding( item ) {
		const idProperty = this._idProperty;
		let itemId;

		if ( ( idProperty in item ) ) {
			itemId = item[ idProperty ];

			if ( typeof itemId != 'string' ) {
				/**
				 * This item's ID should be a string.
				 *
				 * @error collection-add-invalid-id
				 */
				throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'collection-add-invalid-id', this );
			}

			if ( this.get( itemId ) ) {
				/**
				 * This item already exists in the collection.
				 *
				 * @error collection-add-item-already-exists
				 */
				throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'collection-add-item-already-exists', this );
			}
		} else {
			item[ idProperty ] = itemId = (0,_uid__WEBPACK_IMPORTED_MODULE_2__.default)();
		}

		return itemId;
	}

	/**
	 * Core {@link #remove} method implementation shared in other functions.
	 *
	 * In contrast this method **does not** fire the {@link #event:change} event.
	 *
	 * @private
	 * @param {Object} subject The item to remove, its id or index in the collection.
	 * @returns {Array} Returns an array with the removed item and its index.
	 * @fires remove
	 */
	_remove( subject ) {
		let index, id, item;
		let itemDoesNotExist = false;
		const idProperty = this._idProperty;

		if ( typeof subject == 'string' ) {
			id = subject;
			item = this._itemMap.get( id );
			itemDoesNotExist = !item;

			if ( item ) {
				index = this._items.indexOf( item );
			}
		} else if ( typeof subject == 'number' ) {
			index = subject;
			item = this._items[ index ];
			itemDoesNotExist = !item;

			if ( item ) {
				id = item[ idProperty ];
			}
		} else {
			item = subject;
			id = item[ idProperty ];
			index = this._items.indexOf( item );
			itemDoesNotExist = ( index == -1 || !this._itemMap.get( id ) );
		}

		if ( itemDoesNotExist ) {
			/**
			 * Item not found.
			 *
			 * @error collection-remove-404
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'collection-remove-404', this );
		}

		this._items.splice( index, 1 );
		this._itemMap.delete( id );

		const externalItem = this._bindToInternalToExternalMap.get( item );
		this._bindToInternalToExternalMap.delete( item );
		this._bindToExternalToInternalMap.delete( externalItem );

		this.fire( 'remove', item, index );

		return [ item, index ];
	}

	/**
	 * Iterable interface.
	 *
	 * @returns {Iterable.<*>}
	 */
	[ Symbol.iterator ]() {
		return this._items[ Symbol.iterator ]();
	}

	/**
	 * Fired when an item is added to the collection.
	 *
	 * @event add
	 * @param {Object} item The added item.
	 */

	/**
	 * Fired when the collection was changed due to adding or removing items.
	 *
	 * @event change
	 * @param {Iterable.<Object>} added A list of added items.
	 * @param {Iterable.<Object>} removed A list of removed items.
	 * @param {Number} index An index where the addition or removal occurred.
	 */

	/**
	 * Fired when an item is removed from the collection.
	 *
	 * @event remove
	 * @param {Object} item The removed item.
	 * @param {Number} index Index from which item was removed.
	 */
}

(0,_mix__WEBPACK_IMPORTED_MODULE_4__.default)( Collection, _emittermixin__WEBPACK_IMPORTED_MODULE_0__.default );

/**
 * An object returned by the {@link module:utils/collection~Collection#bindTo `bindTo()`} method
 * providing functions that specify the type of the binding.
 *
 * See the {@link module:utils/collection~Collection#bindTo `bindTo()`} documentation for examples.
 *
 * @interface module:utils/collection~CollectionBindToChain
 */

/**
 * Creates a callback or a property binding.
 *
 * @method #using
 * @param {Function|String} callbackOrProperty  When the function is passed, it should return
 * the collection items. When the string is provided, the property value is used to create the bound collection items.
 */

/**
 * Creates the class factory binding in which items of the source collection are passed to
 * the constructor of the specified class.
 *
 * @method #as
 * @param {Function} Class The class constructor used to create instances in the factory.
 */


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/emittermixin.js":
/*!********************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/emittermixin.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__),
/* harmony export */   "_getEmitterListenedTo": () => (/* binding */ _getEmitterListenedTo),
/* harmony export */   "_setEmitterId": () => (/* binding */ _setEmitterId),
/* harmony export */   "_getEmitterId": () => (/* binding */ _getEmitterId)
/* harmony export */ });
/* harmony import */ var _eventinfo__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./eventinfo */ "./node_modules/@ckeditor/ckeditor5-utils/src/eventinfo.js");
/* harmony import */ var _uid__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./uid */ "./node_modules/@ckeditor/ckeditor5-utils/src/uid.js");
/* harmony import */ var _priorities__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./priorities */ "./node_modules/@ckeditor/ckeditor5-utils/src/priorities.js");
/* harmony import */ var _version__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./version */ "./node_modules/@ckeditor/ckeditor5-utils/src/version.js");
/* harmony import */ var _ckeditorerror__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/emittermixin
 */





// To check if component is loaded more than once.



const _listeningTo = Symbol( 'listeningTo' );
const _emitterId = Symbol( 'emitterId' );

/**
 * Mixin that injects the {@link ~Emitter events API} into its host.
 *
 * Read more about the concept of emitters in the:
 * * {@glink framework/guides/architecture/core-editor-architecture#event-system-and-observables Event system and observables}
 * section of the {@glink framework/guides/architecture/core-editor-architecture Core editor architecture} guide.
 * * {@glink framework/guides/deep-dive/event-system Event system} deep dive guide.
 *
 * @mixin EmitterMixin
 * @implements module:utils/emittermixin~Emitter
 */
const EmitterMixin = {
	/**
	 * @inheritDoc
	 */
	on( event, callback, options = {} ) {
		this.listenTo( this, event, callback, options );
	},

	/**
	 * @inheritDoc
	 */
	once( event, callback, options ) {
		let wasFired = false;

		const onceCallback = function( event, ...args ) {
			// Ensure the callback is called only once even if the callback itself leads to re-firing the event
			// (which would call the callback again).
			if ( !wasFired ) {
				wasFired = true;

				// Go off() at the first call.
				event.off();

				// Go with the original callback.
				callback.call( this, event, ...args );
			}
		};

		// Make a similar on() call, simply replacing the callback.
		this.listenTo( this, event, onceCallback, options );
	},

	/**
	 * @inheritDoc
	 */
	off( event, callback ) {
		this.stopListening( this, event, callback );
	},

	/**
	 * @inheritDoc
	 */
	listenTo( emitter, event, callback, options = {} ) {
		let emitterInfo, eventCallbacks;

		// _listeningTo contains a list of emitters that this object is listening to.
		// This list has the following format:
		//
		// _listeningTo: {
		//     emitterId: {
		//         emitter: emitter,
		//         callbacks: {
		//             event1: [ callback1, callback2, ... ]
		//             ....
		//         }
		//     },
		//     ...
		// }

		if ( !this[ _listeningTo ] ) {
			this[ _listeningTo ] = {};
		}

		const emitters = this[ _listeningTo ];

		if ( !_getEmitterId( emitter ) ) {
			_setEmitterId( emitter );
		}

		const emitterId = _getEmitterId( emitter );

		if ( !( emitterInfo = emitters[ emitterId ] ) ) {
			emitterInfo = emitters[ emitterId ] = {
				emitter,
				callbacks: {}
			};
		}

		if ( !( eventCallbacks = emitterInfo.callbacks[ event ] ) ) {
			eventCallbacks = emitterInfo.callbacks[ event ] = [];
		}

		eventCallbacks.push( callback );

		// Finally register the callback to the event.
		addEventListener( this, emitter, event, callback, options );
	},

	/**
	 * @inheritDoc
	 */
	stopListening( emitter, event, callback ) {
		const emitters = this[ _listeningTo ];
		let emitterId = emitter && _getEmitterId( emitter );
		const emitterInfo = emitters && emitterId && emitters[ emitterId ];
		const eventCallbacks = emitterInfo && event && emitterInfo.callbacks[ event ];

		// Stop if nothing has been listened.
		if ( !emitters || ( emitter && !emitterInfo ) || ( event && !eventCallbacks ) ) {
			return;
		}

		// All params provided. off() that single callback.
		if ( callback ) {
			removeEventListener( this, emitter, event, callback );

			// We must remove callbacks as well in order to prevent memory leaks.
			// See https://github.com/ckeditor/ckeditor5/pull/8480
			const index = eventCallbacks.indexOf( callback );

			if ( index !== -1 ) {
				if ( eventCallbacks.length === 1 ) {
					delete emitterInfo.callbacks[ event ];
				} else {
					removeEventListener( this, emitter, event, callback );
				}
			}
		}
		// Only `emitter` and `event` provided. off() all callbacks for that event.
		else if ( eventCallbacks ) {
			while ( ( callback = eventCallbacks.pop() ) ) {
				removeEventListener( this, emitter, event, callback );
			}

			delete emitterInfo.callbacks[ event ];
		}
		// Only `emitter` provided. off() all events for that emitter.
		else if ( emitterInfo ) {
			for ( event in emitterInfo.callbacks ) {
				this.stopListening( emitter, event );
			}
			delete emitters[ emitterId ];
		}
		// No params provided. off() all emitters.
		else {
			for ( emitterId in emitters ) {
				this.stopListening( emitters[ emitterId ].emitter );
			}
			delete this[ _listeningTo ];
		}
	},

	/**
	 * @inheritDoc
	 */
	fire( eventOrInfo, ...args ) {
		try {
			const eventInfo = eventOrInfo instanceof _eventinfo__WEBPACK_IMPORTED_MODULE_0__.default ? eventOrInfo : new _eventinfo__WEBPACK_IMPORTED_MODULE_0__.default( this, eventOrInfo );
			const event = eventInfo.name;
			let callbacks = getCallbacksForEvent( this, event );

			// Record that the event passed this emitter on its path.
			eventInfo.path.push( this );

			// Handle event listener callbacks first.
			if ( callbacks ) {
				// Arguments passed to each callback.
				const callbackArgs = [ eventInfo, ...args ];

				// Copying callbacks array is the easiest and most secure way of preventing infinite loops, when event callbacks
				// are added while processing other callbacks. Previous solution involved adding counters (unique ids) but
				// failed if callbacks were added to the queue before currently processed callback.
				// If this proves to be too inefficient, another method is to change `.on()` so callbacks are stored if same
				// event is currently processed. Then, `.fire()` at the end, would have to add all stored events.
				callbacks = Array.from( callbacks );

				for ( let i = 0; i < callbacks.length; i++ ) {
					callbacks[ i ].callback.apply( this, callbackArgs );

					// Remove the callback from future requests if off() has been called.
					if ( eventInfo.off.called ) {
						// Remove the called mark for the next calls.
						delete eventInfo.off.called;

						this._removeEventListener( event, callbacks[ i ].callback );
					}

					// Do not execute next callbacks if stop() was called.
					if ( eventInfo.stop.called ) {
						break;
					}
				}
			}

			// Delegate event to other emitters if needed.
			if ( this._delegations ) {
				const destinations = this._delegations.get( event );
				const passAllDestinations = this._delegations.get( '*' );

				if ( destinations ) {
					fireDelegatedEvents( destinations, eventInfo, args );
				}

				if ( passAllDestinations ) {
					fireDelegatedEvents( passAllDestinations, eventInfo, args );
				}
			}

			return eventInfo.return;
		} catch ( err ) {
			// @if CK_DEBUG // throw err;
			/* istanbul ignore next */
			_ckeditorerror__WEBPACK_IMPORTED_MODULE_4__.default.rethrowUnexpectedError( err, this );
		}
	},

	/**
	 * @inheritDoc
	 */
	delegate( ...events ) {
		return {
			to: ( emitter, nameOrFunction ) => {
				if ( !this._delegations ) {
					this._delegations = new Map();
				}

				// Originally there was a for..of loop which unfortunately caused an error in Babel that didn't allow
				// build an application. See: https://github.com/ckeditor/ckeditor5-react/issues/40.
				events.forEach( eventName => {
					const destinations = this._delegations.get( eventName );

					if ( !destinations ) {
						this._delegations.set( eventName, new Map( [ [ emitter, nameOrFunction ] ] ) );
					} else {
						destinations.set( emitter, nameOrFunction );
					}
				} );
			}
		};
	},

	/**
	 * @inheritDoc
	 */
	stopDelegating( event, emitter ) {
		if ( !this._delegations ) {
			return;
		}

		if ( !event ) {
			this._delegations.clear();
		} else if ( !emitter ) {
			this._delegations.delete( event );
		} else {
			const destinations = this._delegations.get( event );

			if ( destinations ) {
				destinations.delete( emitter );
			}
		}
	},

	/**
	 * @inheritDoc
	 */
	_addEventListener( event, callback, options ) {
		createEventNamespace( this, event );

		const lists = getCallbacksListsForNamespace( this, event );
		const priority = _priorities__WEBPACK_IMPORTED_MODULE_2__.default.get( options.priority );

		const callbackDefinition = {
			callback,
			priority
		};

		// Add the callback to all callbacks list.
		for ( const callbacks of lists ) {
			// Add the callback to the list in the right priority position.
			let added = false;

			for ( let i = 0; i < callbacks.length; i++ ) {
				if ( callbacks[ i ].priority < priority ) {
					callbacks.splice( i, 0, callbackDefinition );
					added = true;

					break;
				}
			}

			// Add at the end, if right place was not found.
			if ( !added ) {
				callbacks.push( callbackDefinition );
			}
		}
	},

	/**
	 * @inheritDoc
	 */
	_removeEventListener( event, callback ) {
		const lists = getCallbacksListsForNamespace( this, event );

		for ( const callbacks of lists ) {
			for ( let i = 0; i < callbacks.length; i++ ) {
				if ( callbacks[ i ].callback == callback ) {
					// Remove the callback from the list (fixing the next index).
					callbacks.splice( i, 1 );
					i--;
				}
			}
		}
	}
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (EmitterMixin);

/**
 * Emitter/listener interface.
 *
 * Can be easily implemented by a class by mixing the {@link module:utils/emittermixin~EmitterMixin} mixin.
 *
 * Read more about the usage of this interface in the:
 * * {@glink framework/guides/architecture/core-editor-architecture#event-system-and-observables Event system and observables}
 * section of the {@glink framework/guides/architecture/core-editor-architecture Core editor architecture} guide.
 * * {@glink framework/guides/deep-dive/event-system Event system} deep dive guide.
 *
 * @interface Emitter
 */

/**
 * Registers a callback function to be executed when an event is fired.
 *
 * Shorthand for {@link #listenTo `this.listenTo( this, event, callback, options )`} (it makes the emitter
 * listen on itself).
 *
 * @method #on
 * @param {String} event The name of the event.
 * @param {Function} callback The function to be called on event.
 * @param {Object} [options={}] Additional options.
 * @param {module:utils/priorities~PriorityString|Number} [options.priority='normal'] The priority of this event callback. The higher
 * the priority value the sooner the callback will be fired. Events having the same priority are called in the
 * order they were added.
 */

/**
 * Registers a callback function to be executed on the next time the event is fired only. This is similar to
 * calling {@link #on} followed by {@link #off} in the callback.
 *
 * @method #once
 * @param {String} event The name of the event.
 * @param {Function} callback The function to be called on event.
 * @param {Object} [options={}] Additional options.
 * @param {module:utils/priorities~PriorityString|Number} [options.priority='normal'] The priority of this event callback. The higher
 * the priority value the sooner the callback will be fired. Events having the same priority are called in the
 * order they were added.
 */

/**
 * Stops executing the callback on the given event.
 * Shorthand for {@link #stopListening `this.stopListening( this, event, callback )`}.
 *
 * @method #off
 * @param {String} event The name of the event.
 * @param {Function} callback The function to stop being called.
 */

/**
 * Registers a callback function to be executed when an event is fired in a specific (emitter) object.
 *
 * Events can be grouped in namespaces using `:`.
 * When namespaced event is fired, it additionally fires all callbacks for that namespace.
 *
 *		// myEmitter.on( ... ) is a shorthand for myEmitter.listenTo( myEmitter, ... ).
 *		myEmitter.on( 'myGroup', genericCallback );
 *		myEmitter.on( 'myGroup:myEvent', specificCallback );
 *
 *		// genericCallback is fired.
 *		myEmitter.fire( 'myGroup' );
 *		// both genericCallback and specificCallback are fired.
 *		myEmitter.fire( 'myGroup:myEvent' );
 *		// genericCallback is fired even though there are no callbacks for "foo".
 *		myEmitter.fire( 'myGroup:foo' );
 *
 * An event callback can {@link module:utils/eventinfo~EventInfo#stop stop the event} and
 * set the {@link module:utils/eventinfo~EventInfo#return return value} of the {@link #fire} method.
 *
 * @method #listenTo
 * @param {module:utils/emittermixin~Emitter} emitter The object that fires the event.
 * @param {String} event The name of the event.
 * @param {Function} callback The function to be called on event.
 * @param {Object} [options={}] Additional options.
 * @param {module:utils/priorities~PriorityString|Number} [options.priority='normal'] The priority of this event callback. The higher
 * the priority value the sooner the callback will be fired. Events having the same priority are called in the
 * order they were added.
 */

/**
 * Stops listening for events. It can be used at different levels:
 *
 * * To stop listening to a specific callback.
 * * To stop listening to a specific event.
 * * To stop listening to all events fired by a specific object.
 * * To stop listening to all events fired by all objects.
 *
 * @method #stopListening
 * @param {module:utils/emittermixin~Emitter} [emitter] The object to stop listening to. If omitted, stops it for all objects.
 * @param {String} [event] (Requires the `emitter`) The name of the event to stop listening to. If omitted, stops it
 * for all events from `emitter`.
 * @param {Function} [callback] (Requires the `event`) The function to be removed from the call list for the given
 * `event`.
 */

/**
 * Fires an event, executing all callbacks registered for it.
 *
 * The first parameter passed to callbacks is an {@link module:utils/eventinfo~EventInfo} object,
 * followed by the optional `args` provided in the `fire()` method call.
 *
 * @method #fire
 * @param {String|module:utils/eventinfo~EventInfo} eventOrInfo The name of the event or `EventInfo` object if event is delegated.
 * @param {...*} [args] Additional arguments to be passed to the callbacks.
 * @returns {*} By default the method returns `undefined`. However, the return value can be changed by listeners
 * through modification of the {@link module:utils/eventinfo~EventInfo#return `evt.return`}'s property (the event info
 * is the first param of every callback).
 */

/**
 * Delegates selected events to another {@link module:utils/emittermixin~Emitter}. For instance:
 *
 *		emitterA.delegate( 'eventX' ).to( emitterB );
 *		emitterA.delegate( 'eventX', 'eventY' ).to( emitterC );
 *
 * then `eventX` is delegated (fired by) `emitterB` and `emitterC` along with `data`:
 *
 *		emitterA.fire( 'eventX', data );
 *
 * and `eventY` is delegated (fired by) `emitterC` along with `data`:
 *
 *		emitterA.fire( 'eventY', data );
 *
 * @method #delegate
 * @param {...String} events Event names that will be delegated to another emitter.
 * @returns {module:utils/emittermixin~EmitterMixinDelegateChain}
 */

/**
 * Stops delegating events. It can be used at different levels:
 *
 * * To stop delegating all events.
 * * To stop delegating a specific event to all emitters.
 * * To stop delegating a specific event to a specific emitter.
 *
 * @method #stopDelegating
 * @param {String} [event] The name of the event to stop delegating. If omitted, stops it all delegations.
 * @param {module:utils/emittermixin~Emitter} [emitter] (requires `event`) The object to stop delegating a particular event to.
 * If omitted, stops delegation of `event` to all emitters.
 */

/**
 * Adds callback to emitter for given event.
 *
 * @protected
 * @method #_addEventListener
 * @param {String} event The name of the event.
 * @param {Function} callback The function to be called on event.
 * @param {Object} [options={}] Additional options.
 * @param {module:utils/priorities~PriorityString|Number} [options.priority='normal'] The priority of this event callback. The higher
 * the priority value the sooner the callback will be fired. Events having the same priority are called in the
 * order they were added.
 */

/**
 * Removes callback from emitter for given event.
 *
 * @protected
 * @method #_removeEventListener
 * @param {String} event The name of the event.
 * @param {Function} callback The function to stop being called.
 */

/**
 * Checks if `listeningEmitter` listens to an emitter with given `listenedToEmitterId` and if so, returns that emitter.
 * If not, returns `null`.
 *
 * @protected
 * @param {module:utils/emittermixin~Emitter} listeningEmitter An emitter that listens.
 * @param {String} listenedToEmitterId Unique emitter id of emitter listened to.
 * @returns {module:utils/emittermixin~Emitter|null}
 */
function _getEmitterListenedTo( listeningEmitter, listenedToEmitterId ) {
	if ( listeningEmitter[ _listeningTo ] && listeningEmitter[ _listeningTo ][ listenedToEmitterId ] ) {
		return listeningEmitter[ _listeningTo ][ listenedToEmitterId ].emitter;
	}

	return null;
}

/**
 * Sets emitter's unique id.
 *
 * **Note:** `_emitterId` can be set only once.
 *
 * @protected
 * @param {module:utils/emittermixin~Emitter} emitter An emitter for which id will be set.
 * @param {String} [id] Unique id to set. If not passed, random unique id will be set.
 */
function _setEmitterId( emitter, id ) {
	if ( !emitter[ _emitterId ] ) {
		emitter[ _emitterId ] = id || (0,_uid__WEBPACK_IMPORTED_MODULE_1__.default)();
	}
}

/**
 * Returns emitter's unique id.
 *
 * @protected
 * @param {module:utils/emittermixin~Emitter} emitter An emitter which id will be returned.
 */
function _getEmitterId( emitter ) {
	return emitter[ _emitterId ];
}

// Gets the internal `_events` property of the given object.
// `_events` property store all lists with callbacks for registered event names.
// If there were no events registered on the object, empty `_events` object is created.
function getEvents( source ) {
	if ( !source._events ) {
		Object.defineProperty( source, '_events', {
			value: {}
		} );
	}

	return source._events;
}

// Creates event node for generic-specific events relation architecture.
function makeEventNode() {
	return {
		callbacks: [],
		childEvents: []
	};
}

// Creates an architecture for generic-specific events relation.
// If needed, creates all events for given eventName, i.e. if the first registered event
// is foo:bar:abc, it will create foo:bar:abc, foo:bar and foo event and tie them together.
// It also copies callbacks from more generic events to more specific events when
// specific events are created.
function createEventNamespace( source, eventName ) {
	const events = getEvents( source );

	// First, check if the event we want to add to the structure already exists.
	if ( events[ eventName ] ) {
		// If it exists, we don't have to do anything.
		return;
	}

	// In other case, we have to create the structure for the event.
	// Note, that we might need to create intermediate events too.
	// I.e. if foo:bar:abc is being registered and we only have foo in the structure,
	// we need to also register foo:bar.

	// Currently processed event name.
	let name = eventName;
	// Name of the event that is a child event for currently processed event.
	let childEventName = null;

	// Array containing all newly created specific events.
	const newEventNodes = [];

	// While loop can't check for ':' index because we have to handle generic events too.
	// In each loop, we truncate event name, going from the most specific name to the generic one.
	// I.e. foo:bar:abc -> foo:bar -> foo.
	while ( name !== '' ) {
		if ( events[ name ] ) {
			// If the currently processed event name is already registered, we can be sure
			// that it already has all the structure created, so we can break the loop here
			// as no more events need to be registered.
			break;
		}

		// If this event is not yet registered, create a new object for it.
		events[ name ] = makeEventNode();
		// Add it to the array with newly created events.
		newEventNodes.push( events[ name ] );

		// Add previously processed event name as a child of this event.
		if ( childEventName ) {
			events[ name ].childEvents.push( childEventName );
		}

		childEventName = name;
		// If `.lastIndexOf()` returns -1, `.substr()` will return '' which will break the loop.
		name = name.substr( 0, name.lastIndexOf( ':' ) );
	}

	if ( name !== '' ) {
		// If name is not empty, we found an already registered event that was a parent of the
		// event we wanted to register.

		// Copy that event's callbacks to newly registered events.
		for ( const node of newEventNodes ) {
			node.callbacks = events[ name ].callbacks.slice();
		}

		// Add last newly created event to the already registered event.
		events[ name ].childEvents.push( childEventName );
	}
}

// Gets an array containing callbacks list for a given event and it's more specific events.
// I.e. if given event is foo:bar and there is also foo:bar:abc event registered, this will
// return callback list of foo:bar and foo:bar:abc (but not foo).
function getCallbacksListsForNamespace( source, eventName ) {
	const eventNode = getEvents( source )[ eventName ];

	if ( !eventNode ) {
		return [];
	}

	let callbacksLists = [ eventNode.callbacks ];

	for ( let i = 0; i < eventNode.childEvents.length; i++ ) {
		const childCallbacksLists = getCallbacksListsForNamespace( source, eventNode.childEvents[ i ] );

		callbacksLists = callbacksLists.concat( childCallbacksLists );
	}

	return callbacksLists;
}

// Get the list of callbacks for a given event, but only if there any callbacks have been registered.
// If there are no callbacks registered for given event, it checks if this is a specific event and looks
// for callbacks for it's more generic version.
function getCallbacksForEvent( source, eventName ) {
	let event;

	if ( !source._events || !( event = source._events[ eventName ] ) || !event.callbacks.length ) {
		// There are no callbacks registered for specified eventName.
		// But this could be a specific-type event that is in a namespace.
		if ( eventName.indexOf( ':' ) > -1 ) {
			// If the eventName is specific, try to find callback lists for more generic event.
			return getCallbacksForEvent( source, eventName.substr( 0, eventName.lastIndexOf( ':' ) ) );
		} else {
			// If this is a top-level generic event, return null;
			return null;
		}
	}

	return event.callbacks;
}

// Fires delegated events for given map of destinations.
//
// @private
// * @param {Map.<utils.Emitter>} destinations A map containing
// `[ {@link module:utils/emittermixin~Emitter}, "event name" ]` pair destinations.
// * @param {utils.EventInfo} eventInfo The original event info object.
// * @param {Array.<*>} fireArgs Arguments the original event was fired with.
function fireDelegatedEvents( destinations, eventInfo, fireArgs ) {
	for ( let [ emitter, name ] of destinations ) {
		if ( !name ) {
			name = eventInfo.name;
		} else if ( typeof name == 'function' ) {
			name = name( eventInfo.name );
		}

		const delegatedInfo = new _eventinfo__WEBPACK_IMPORTED_MODULE_0__.default( eventInfo.source, name );

		delegatedInfo.path = [ ...eventInfo.path ];

		emitter.fire( delegatedInfo, ...fireArgs );
	}
}

// Helper for registering event callback on the emitter.
function addEventListener( listener, emitter, event, callback, options ) {
	if ( emitter._addEventListener ) {
		emitter._addEventListener( event, callback, options );
	} else {
		// Allow listening on objects that do not implement Emitter interface.
		// This is needed in some tests that are using mocks instead of the real objects with EmitterMixin mixed.
		listener._addEventListener.call( emitter, event, callback, options );
	}
}

// Helper for removing event callback from the emitter.
function removeEventListener( listener, emitter, event, callback ) {
	if ( emitter._removeEventListener ) {
		emitter._removeEventListener( event, callback );
	} else {
		// Allow listening on objects that do not implement Emitter interface.
		// This is needed in some tests that are using mocks instead of the real objects with EmitterMixin mixed.
		listener._removeEventListener.call( emitter, event, callback );
	}
}

/**
 * The return value of {@link ~EmitterMixin#delegate}.
 *
 * @interface module:utils/emittermixin~EmitterMixinDelegateChain
 */

/**
 * Selects destination for {@link module:utils/emittermixin~EmitterMixin#delegate} events.
 *
 * @method #to
 * @param {module:utils/emittermixin~Emitter} emitter An `EmitterMixin` instance which is the destination for delegated events.
 * @param {String|Function} [nameOrFunction] A custom event name or function which converts the original name string.
 */


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/eventinfo.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/eventinfo.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ EventInfo)
/* harmony export */ });
/* harmony import */ var _spy__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./spy */ "./node_modules/@ckeditor/ckeditor5-utils/src/spy.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/eventinfo
 */



/**
 * The event object passed to event callbacks. It is used to provide information about the event as well as a tool to
 * manipulate it.
 */
class EventInfo {
	/**
	 * @param {Object} source The emitter.
	 * @param {String} name The event name.
	 */
	constructor( source, name ) {
		/**
		 * The object that fired the event.
		 *
		 * @readonly
		 * @member {Object}
		 */
		this.source = source;

		/**
		 * The event name.
		 *
		 * @readonly
		 * @member {String}
		 */
		this.name = name;

		/**
		 * Path this event has followed. See {@link module:utils/emittermixin~EmitterMixin#delegate}.
		 *
		 * @readonly
		 * @member {Array.<Object>}
		 */
		this.path = [];

		// The following methods are defined in the constructor because they must be re-created per instance.

		/**
		 * Stops the event emitter to call further callbacks for this event interaction.
		 *
		 * @method #stop
		 */
		this.stop = (0,_spy__WEBPACK_IMPORTED_MODULE_0__.default)();

		/**
		 * Removes the current callback from future interactions of this event.
		 *
		 * @method #off
		 */
		this.off = (0,_spy__WEBPACK_IMPORTED_MODULE_0__.default)();

		/**
		 * The value which will be returned by {@link module:utils/emittermixin~EmitterMixin#fire}.
		 *
		 * It's `undefined` by default and can be changed by an event listener:
		 *
		 *		dataController.fire( 'getSelectedContent', ( evt ) => {
		 *			// This listener will make `dataController.fire( 'getSelectedContent' )`
		 *			// always return an empty DocumentFragment.
		 *			evt.return = new DocumentFragment();
		 *
		 *			// Make sure no other listeners are executed.
		 *			evt.stop();
		 *		} );
		 *
		 * @member #return
		 */
	}
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/isiterable.js":
/*!******************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/isiterable.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ isIterable)
/* harmony export */ });
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/isiterable
 */

/**
 * Checks if value implements iterator interface.
 *
 * @param {*} value The value to check.
 * @returns {Boolean} True if value implements iterator interface.
 */
function isIterable( value ) {
	return !!( value && value[ Symbol.iterator ] );
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/mix.js":
/*!***********************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/mix.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ mix)
/* harmony export */ });
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/mix
 */

/**
 * Copies enumerable properties and symbols from the objects given as 2nd+ parameters to the
 * prototype of first object (a constructor).
 *
 *		class Editor {
 *			...
 *		}
 *
 *		const SomeMixin = {
 *			a() {
 *				return 'a';
 *			}
 *		};
 *
 *		mix( Editor, SomeMixin, ... );
 *
 *		new Editor().a(); // -> 'a'
 *
 * Note: Properties which already exist in the base class will not be overriden.
 *
 * @param {Function} [baseClass] Class which prototype will be extended.
 * @param {Object} [...mixins] Objects from which to get properties.
 */
function mix( baseClass, ...mixins ) {
	mixins.forEach( mixin => {
		Object.getOwnPropertyNames( mixin ).concat( Object.getOwnPropertySymbols( mixin ) )
			.forEach( key => {
				if ( key in baseClass.prototype ) {
					return;
				}

				const sourceDescriptor = Object.getOwnPropertyDescriptor( mixin, key );
				sourceDescriptor.enumerable = false;

				Object.defineProperty( baseClass.prototype, key, sourceDescriptor );
			} );
	} );
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/observablemixin.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _emittermixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./emittermixin */ "./node_modules/@ckeditor/ckeditor5-utils/src/emittermixin.js");
/* harmony import */ var _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/* harmony import */ var lodash_es__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash-es */ "./node_modules/lodash-es/isObject.js");
/* harmony import */ var lodash_es__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash-es */ "./node_modules/lodash-es/assignIn.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/observablemixin
 */





const observablePropertiesSymbol = Symbol( 'observableProperties' );
const boundObservablesSymbol = Symbol( 'boundObservables' );
const boundPropertiesSymbol = Symbol( 'boundProperties' );

const _decoratedMethods = Symbol( 'decoratedMethods' );
const _decoratedOriginal = Symbol( 'decoratedOriginal' );

/**
 * A mixin that injects the "observable properties" and data binding functionality described in the
 * {@link ~Observable} interface.
 *
 * Read more about the concept of observables in the:
 * * {@glink framework/guides/architecture/core-editor-architecture#event-system-and-observables Event system and observables}
 * section of the {@glink framework/guides/architecture/core-editor-architecture Core editor architecture} guide,
 * * {@glink framework/guides/deep-dive/observables Observables deep dive} guide.
 *
 * @mixin ObservableMixin
 * @mixes module:utils/emittermixin~EmitterMixin
 * @implements module:utils/observablemixin~Observable
 */
const ObservableMixin = {
	/**
	 * @inheritDoc
	 */
	set( name, value ) {
		// If the first parameter is an Object, iterate over its properties.
		if ( (0,lodash_es__WEBPACK_IMPORTED_MODULE_2__.default)( name ) ) {
			Object.keys( name ).forEach( property => {
				this.set( property, name[ property ] );
			}, this );

			return;
		}

		initObservable( this );

		const properties = this[ observablePropertiesSymbol ];

		if ( ( name in this ) && !properties.has( name ) ) {
			/**
			 * Cannot override an existing property.
			 *
			 * This error is thrown when trying to {@link ~Observable#set set} a property with
			 * a name of an already existing property. For example:
			 *
			 *		let observable = new Model();
			 *		observable.property = 1;
			 *		observable.set( 'property', 2 );			// throws
			 *
			 *		observable.set( 'property', 1 );
			 *		observable.set( 'property', 2 );			// ok, because this is an existing property.
			 *
			 * @error observable-set-cannot-override
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-set-cannot-override', this );
		}

		Object.defineProperty( this, name, {
			enumerable: true,
			configurable: true,

			get() {
				return properties.get( name );
			},

			set( value ) {
				const oldValue = properties.get( name );

				// Fire `set` event before the new value will be set to make it possible
				// to override observable property without affecting `change` event.
				// See https://github.com/ckeditor/ckeditor5-utils/issues/171.
				let newValue = this.fire( 'set:' + name, name, value, oldValue );

				if ( newValue === undefined ) {
					newValue = value;
				}

				// Allow undefined as an initial value like A.define( 'x', undefined ) (#132).
				// Note: When properties map has no such own property, then its value is undefined.
				if ( oldValue !== newValue || !properties.has( name ) ) {
					properties.set( name, newValue );
					this.fire( 'change:' + name, name, newValue, oldValue );
				}
			}
		} );

		this[ name ] = value;
	},

	/**
	 * @inheritDoc
	 */
	bind( ...bindProperties ) {
		if ( !bindProperties.length || !isStringArray( bindProperties ) ) {
			/**
			 * All properties must be strings.
			 *
			 * @error observable-bind-wrong-properties
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-wrong-properties', this );
		}

		if ( ( new Set( bindProperties ) ).size !== bindProperties.length ) {
			/**
			 * Properties must be unique.
			 *
			 * @error observable-bind-duplicate-properties
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-duplicate-properties', this );
		}

		initObservable( this );

		const boundProperties = this[ boundPropertiesSymbol ];

		bindProperties.forEach( propertyName => {
			if ( boundProperties.has( propertyName ) ) {
				/**
				 * Cannot bind the same property more than once.
				 *
				 * @error observable-bind-rebind
				 */
				throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-rebind', this );
			}
		} );

		const bindings = new Map();

		// @typedef {Object} Binding
		// @property {Array} property Property which is bound.
		// @property {Array} to Array of observable–property components of the binding (`{ observable: ..., property: .. }`).
		// @property {Array} callback A function which processes `to` components.
		bindProperties.forEach( a => {
			const binding = { property: a, to: [] };

			boundProperties.set( a, binding );
			bindings.set( a, binding );
		} );

		// @typedef {Object} BindChain
		// @property {Function} to See {@link ~ObservableMixin#_bindTo}.
		// @property {Function} toMany See {@link ~ObservableMixin#_bindToMany}.
		// @property {module:utils/observablemixin~Observable} _observable The observable which initializes the binding.
		// @property {Array} _bindProperties Array of `_observable` properties to be bound.
		// @property {Array} _to Array of `to()` observable–properties (`{ observable: toObservable, properties: ...toProperties }`).
		// @property {Map} _bindings Stores bindings to be kept in
		// {@link ~ObservableMixin#_boundProperties}/{@link ~ObservableMixin#_boundObservables}
		// initiated in this binding chain.
		return {
			to: bindTo,
			toMany: bindToMany,

			_observable: this,
			_bindProperties: bindProperties,
			_to: [],
			_bindings: bindings
		};
	},

	/**
	 * @inheritDoc
	 */
	unbind( ...unbindProperties ) {
		// Nothing to do here if not inited yet.
		if ( !( this[ observablePropertiesSymbol ] ) ) {
			return;
		}

		const boundProperties = this[ boundPropertiesSymbol ];
		const boundObservables = this[ boundObservablesSymbol ];

		if ( unbindProperties.length ) {
			if ( !isStringArray( unbindProperties ) ) {
				/**
				 * Properties must be strings.
				 *
				 * @error observable-unbind-wrong-properties
				 */
				throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-unbind-wrong-properties', this );
			}

			unbindProperties.forEach( propertyName => {
				const binding = boundProperties.get( propertyName );

				// Nothing to do if the binding is not defined
				if ( !binding ) {
					return;
				}

				let toObservable, toProperty, toProperties, toPropertyBindings;

				binding.to.forEach( to => {
					// TODO: ES6 destructuring.
					toObservable = to[ 0 ];
					toProperty = to[ 1 ];
					toProperties = boundObservables.get( toObservable );
					toPropertyBindings = toProperties[ toProperty ];

					toPropertyBindings.delete( binding );

					if ( !toPropertyBindings.size ) {
						delete toProperties[ toProperty ];
					}

					if ( !Object.keys( toProperties ).length ) {
						boundObservables.delete( toObservable );
						this.stopListening( toObservable, 'change' );
					}
				} );

				boundProperties.delete( propertyName );
			} );
		} else {
			boundObservables.forEach( ( bindings, boundObservable ) => {
				this.stopListening( boundObservable, 'change' );
			} );

			boundObservables.clear();
			boundProperties.clear();
		}
	},

	/**
	 * @inheritDoc
	 */
	decorate( methodName ) {
		const originalMethod = this[ methodName ];

		if ( !originalMethod ) {
			/**
			 * Cannot decorate an undefined method.
			 *
			 * @error observablemixin-cannot-decorate-undefined
			 * @param {Object} object The object which method should be decorated.
			 * @param {String} methodName Name of the method which does not exist.
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default(
				'observablemixin-cannot-decorate-undefined',
				this,
				{ object: this, methodName }
			);
		}

		this.on( methodName, ( evt, args ) => {
			evt.return = originalMethod.apply( this, args );
		} );

		this[ methodName ] = function( ...args ) {
			return this.fire( methodName, args );
		};

		this[ methodName ][ _decoratedOriginal ] = originalMethod;

		if ( !this[ _decoratedMethods ] ) {
			this[ _decoratedMethods ] = [];
		}

		this[ _decoratedMethods ].push( methodName );
	}
};

(0,lodash_es__WEBPACK_IMPORTED_MODULE_3__.default)( ObservableMixin, _emittermixin__WEBPACK_IMPORTED_MODULE_0__.default );

// Override the EmitterMixin stopListening method to be able to clean (and restore) decorated methods.
// This is needed in case of:
//  1. Have x.foo() decorated.
//  2. Call x.stopListening()
//  3. Call x.foo(). Problem: nothing happens (the original foo() method is not executed)
ObservableMixin.stopListening = function( emitter, event, callback ) {
	// Removing all listeners so let's clean the decorated methods to the original state.
	if ( !emitter && this[ _decoratedMethods ] ) {
		for ( const methodName of this[ _decoratedMethods ] ) {
			this[ methodName ] = this[ methodName ][ _decoratedOriginal ];
		}

		delete this[ _decoratedMethods ];
	}

	_emittermixin__WEBPACK_IMPORTED_MODULE_0__.default.stopListening.call( this, emitter, event, callback );
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ObservableMixin);

// Init symbol properties needed for the observable mechanism to work.
//
// @private
// @param {module:utils/observablemixin~ObservableMixin} observable
function initObservable( observable ) {
	// Do nothing if already inited.
	if ( observable[ observablePropertiesSymbol ] ) {
		return;
	}

	// The internal hash containing the observable's state.
	//
	// @private
	// @type {Map}
	Object.defineProperty( observable, observablePropertiesSymbol, {
		value: new Map()
	} );

	// Map containing bindings to external observables. It shares the binding objects
	// (`{ observable: A, property: 'a', to: ... }`) with {@link module:utils/observablemixin~ObservableMixin#_boundProperties} and
	// it is used to observe external observables to update own properties accordingly.
	// See {@link module:utils/observablemixin~ObservableMixin#bind}.
	//
	//		A.bind( 'a', 'b', 'c' ).to( B, 'x', 'y', 'x' );
	//		console.log( A._boundObservables );
	//
	//			Map( {
	//				B: {
	//					x: Set( [
	//						{ observable: A, property: 'a', to: [ [ B, 'x' ] ] },
	//						{ observable: A, property: 'c', to: [ [ B, 'x' ] ] }
	//					] ),
	//					y: Set( [
	//						{ observable: A, property: 'b', to: [ [ B, 'y' ] ] },
	//					] )
	//				}
	//			} )
	//
	//		A.bind( 'd' ).to( B, 'z' ).to( C, 'w' ).as( callback );
	//		console.log( A._boundObservables );
	//
	//			Map( {
	//				B: {
	//					x: Set( [
	//						{ observable: A, property: 'a', to: [ [ B, 'x' ] ] },
	//						{ observable: A, property: 'c', to: [ [ B, 'x' ] ] }
	//					] ),
	//					y: Set( [
	//						{ observable: A, property: 'b', to: [ [ B, 'y' ] ] },
	//					] ),
	//					z: Set( [
	//						{ observable: A, property: 'd', to: [ [ B, 'z' ], [ C, 'w' ] ], callback: callback }
	//					] )
	//				},
	//				C: {
	//					w: Set( [
	//						{ observable: A, property: 'd', to: [ [ B, 'z' ], [ C, 'w' ] ], callback: callback }
	//					] )
	//				}
	//			} )
	//
	// @private
	// @type {Map}
	Object.defineProperty( observable, boundObservablesSymbol, {
		value: new Map()
	} );

	// Object that stores which properties of this observable are bound and how. It shares
	// the binding objects (`{ observable: A, property: 'a', to: ... }`) with
	// {@link module:utils/observablemixin~ObservableMixin#_boundObservables}. This data structure is
	// a reverse of {@link module:utils/observablemixin~ObservableMixin#_boundObservables} and it is helpful for
	// {@link module:utils/observablemixin~ObservableMixin#unbind}.
	//
	// See {@link module:utils/observablemixin~ObservableMixin#bind}.
	//
	//		A.bind( 'a', 'b', 'c' ).to( B, 'x', 'y', 'x' );
	//		console.log( A._boundProperties );
	//
	//			Map( {
	//				a: { observable: A, property: 'a', to: [ [ B, 'x' ] ] },
	//				b: { observable: A, property: 'b', to: [ [ B, 'y' ] ] },
	//				c: { observable: A, property: 'c', to: [ [ B, 'x' ] ] }
	//			} )
	//
	//		A.bind( 'd' ).to( B, 'z' ).to( C, 'w' ).as( callback );
	//		console.log( A._boundProperties );
	//
	//			Map( {
	//				a: { observable: A, property: 'a', to: [ [ B, 'x' ] ] },
	//				b: { observable: A, property: 'b', to: [ [ B, 'y' ] ] },
	//				c: { observable: A, property: 'c', to: [ [ B, 'x' ] ] },
	//				d: { observable: A, property: 'd', to: [ [ B, 'z' ], [ C, 'w' ] ], callback: callback }
	//			} )
	//
	// @private
	// @type {Map}
	Object.defineProperty( observable, boundPropertiesSymbol, {
		value: new Map()
	} );
}

// A chaining for {@link module:utils/observablemixin~ObservableMixin#bind} providing `.to()` interface.
//
// @private
// @param {...[Observable|String|Function]} args Arguments of the `.to( args )` binding.
function bindTo( ...args ) {
	const parsedArgs = parseBindToArgs( ...args );
	const bindingsKeys = Array.from( this._bindings.keys() );
	const numberOfBindings = bindingsKeys.length;

	// Eliminate A.bind( 'x' ).to( B, C )
	if ( !parsedArgs.callback && parsedArgs.to.length > 1 ) {
		/**
		 * Binding multiple observables only possible with callback.
		 *
		 * @error observable-bind-to-no-callback
		 */
		throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-to-no-callback', this );
	}

	// Eliminate A.bind( 'x', 'y' ).to( B, callback )
	if ( numberOfBindings > 1 && parsedArgs.callback ) {
		/**
		 * Cannot bind multiple properties and use a callback in one binding.
		 *
		 * @error observable-bind-to-extra-callback
		 */
		throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default(
			'observable-bind-to-extra-callback',
			this
		);
	}

	parsedArgs.to.forEach( to => {
		// Eliminate A.bind( 'x', 'y' ).to( B, 'a' )
		if ( to.properties.length && to.properties.length !== numberOfBindings ) {
			/**
			 * The number of properties must match.
			 *
			 * @error observable-bind-to-properties-length
			 */
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-to-properties-length', this );
		}

		// When no to.properties specified, observing source properties instead i.e.
		// A.bind( 'x', 'y' ).to( B ) -> Observe B.x and B.y
		if ( !to.properties.length ) {
			to.properties = this._bindProperties;
		}
	} );

	this._to = parsedArgs.to;

	// Fill {@link BindChain#_bindings} with callback. When the callback is set there's only one binding.
	if ( parsedArgs.callback ) {
		this._bindings.get( bindingsKeys[ 0 ] ).callback = parsedArgs.callback;
	}

	attachBindToListeners( this._observable, this._to );

	// Update observable._boundProperties and observable._boundObservables.
	updateBindToBound( this );

	// Set initial values of bound properties.
	this._bindProperties.forEach( propertyName => {
		updateBoundObservableProperty( this._observable, propertyName );
	} );
}

// Binds to an attribute in a set of iterable observables.
//
// @private
// @param {Array.<Observable>} observables
// @param {String} attribute
// @param {Function} callback
function bindToMany( observables, attribute, callback ) {
	if ( this._bindings.size > 1 ) {
		/**
		 * Binding one attribute to many observables only possible with one attribute.
		 *
		 * @error observable-bind-to-many-not-one-binding
		 */
		throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-to-many-not-one-binding', this );
	}

	this.to(
		// Bind to #attribute of each observable...
		...getBindingTargets( observables, attribute ),
		// ...using given callback to parse attribute values.
		callback
	);
}

// Returns an array of binding components for
// {@link Observable#bind} from a set of iterable observables.
//
// @param {Array.<Observable>} observables
// @param {String} attribute
// @returns {Array.<String|Observable>}
function getBindingTargets( observables, attribute ) {
	const observableAndAttributePairs = observables.map( observable => [ observable, attribute ] );

	// Merge pairs to one-dimension array of observables and attributes.
	return Array.prototype.concat.apply( [], observableAndAttributePairs );
}

// Check if all entries of the array are of `String` type.
//
// @private
// @param {Array} arr An array to be checked.
// @returns {Boolean}
function isStringArray( arr ) {
	return arr.every( a => typeof a == 'string' );
}

// Parses and validates {@link Observable#bind}`.to( args )` arguments and returns
// an object with a parsed structure. For example
//
//		A.bind( 'x' ).to( B, 'a', C, 'b', call );
//
// becomes
//
//		{
//			to: [
//				{ observable: B, properties: [ 'a' ] },
//				{ observable: C, properties: [ 'b' ] },
//			],
//			callback: call
// 		}
//
// @private
// @param {...*} args Arguments of {@link Observable#bind}`.to( args )`.
// @returns {Object}
function parseBindToArgs( ...args ) {
	// Eliminate A.bind( 'x' ).to()
	if ( !args.length ) {
		/**
		 * Invalid argument syntax in `to()`.
		 *
		 * @error observable-bind-to-parse-error
		 */
		throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-to-parse-error', null );
	}

	const parsed = { to: [] };
	let lastObservable;

	if ( typeof args[ args.length - 1 ] == 'function' ) {
		parsed.callback = args.pop();
	}

	args.forEach( a => {
		if ( typeof a == 'string' ) {
			lastObservable.properties.push( a );
		} else if ( typeof a == 'object' ) {
			lastObservable = { observable: a, properties: [] };
			parsed.to.push( lastObservable );
		} else {
			throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_1__.default( 'observable-bind-to-parse-error', null );
		}
	} );

	return parsed;
}

// Synchronizes {@link module:utils/observablemixin#_boundObservables} with {@link Binding}.
//
// @private
// @param {Binding} binding A binding to store in {@link Observable#_boundObservables}.
// @param {Observable} toObservable A observable, which is a new component of `binding`.
// @param {String} toPropertyName A name of `toObservable`'s property, a new component of the `binding`.
function updateBoundObservables( observable, binding, toObservable, toPropertyName ) {
	const boundObservables = observable[ boundObservablesSymbol ];
	const bindingsToObservable = boundObservables.get( toObservable );
	const bindings = bindingsToObservable || {};

	if ( !bindings[ toPropertyName ] ) {
		bindings[ toPropertyName ] = new Set();
	}

	// Pass the binding to a corresponding Set in `observable._boundObservables`.
	bindings[ toPropertyName ].add( binding );

	if ( !bindingsToObservable ) {
		boundObservables.set( toObservable, bindings );
	}
}

// Synchronizes {@link Observable#_boundProperties} and {@link Observable#_boundObservables}
// with {@link BindChain}.
//
// Assuming the following binding being created
//
// 		A.bind( 'a', 'b' ).to( B, 'x', 'y' );
//
// the following bindings were initialized by {@link Observable#bind} in {@link BindChain#_bindings}:
//
// 		{
// 			a: { observable: A, property: 'a', to: [] },
// 			b: { observable: A, property: 'b', to: [] },
// 		}
//
// Iterate over all bindings in this chain and fill their `to` properties with
// corresponding to( ... ) arguments (components of the binding), so
//
// 		{
// 			a: { observable: A, property: 'a', to: [ B, 'x' ] },
// 			b: { observable: A, property: 'b', to: [ B, 'y' ] },
// 		}
//
// Then update the structure of {@link Observable#_boundObservables} with updated
// binding, so it becomes:
//
// 		Map( {
// 			B: {
// 				x: Set( [
// 					{ observable: A, property: 'a', to: [ [ B, 'x' ] ] }
// 				] ),
// 				y: Set( [
// 					{ observable: A, property: 'b', to: [ [ B, 'y' ] ] },
// 				] )
//			}
// 		} )
//
// @private
// @param {BindChain} chain The binding initialized by {@link Observable#bind}.
function updateBindToBound( chain ) {
	let toProperty;

	chain._bindings.forEach( ( binding, propertyName ) => {
		// Note: For a binding without a callback, this will run only once
		// like in A.bind( 'x', 'y' ).to( B, 'a', 'b' )
		// TODO: ES6 destructuring.
		chain._to.forEach( to => {
			toProperty = to.properties[ binding.callback ? 0 : chain._bindProperties.indexOf( propertyName ) ];

			binding.to.push( [ to.observable, toProperty ] );
			updateBoundObservables( chain._observable, binding, to.observable, toProperty );
		} );
	} );
}

// Updates an property of a {@link Observable} with a value
// determined by an entry in {@link Observable#_boundProperties}.
//
// @private
// @param {Observable} observable A observable which property is to be updated.
// @param {String} propertyName An property to be updated.
function updateBoundObservableProperty( observable, propertyName ) {
	const boundProperties = observable[ boundPropertiesSymbol ];
	const binding = boundProperties.get( propertyName );
	let propertyValue;

	// When a binding with callback is created like
	//
	// 		A.bind( 'a' ).to( B, 'b', C, 'c', callback );
	//
	// collect B.b and C.c, then pass them to callback to set A.a.
	if ( binding.callback ) {
		propertyValue = binding.callback.apply( observable, binding.to.map( to => to[ 0 ][ to[ 1 ] ] ) );
	} else {
		propertyValue = binding.to[ 0 ];
		propertyValue = propertyValue[ 0 ][ propertyValue[ 1 ] ];
	}

	if ( Object.prototype.hasOwnProperty.call( observable, propertyName ) ) {
		observable[ propertyName ] = propertyValue;
	} else {
		observable.set( propertyName, propertyValue );
	}
}

// Starts listening to changes in {@link BindChain._to} observables to update
// {@link BindChain._observable} {@link BindChain._bindProperties}. Also sets the
// initial state of {@link BindChain._observable}.
//
// @private
// @param {BindChain} chain The chain initialized by {@link Observable#bind}.
function attachBindToListeners( observable, toBindings ) {
	toBindings.forEach( to => {
		const boundObservables = observable[ boundObservablesSymbol ];
		let bindings;

		// If there's already a chain between the observables (`observable` listens to
		// `to.observable`), there's no need to create another `change` event listener.
		if ( !boundObservables.get( to.observable ) ) {
			observable.listenTo( to.observable, 'change', ( evt, propertyName ) => {
				bindings = boundObservables.get( to.observable )[ propertyName ];

				// Note: to.observable will fire for any property change, react
				// to changes of properties which are bound only.
				if ( bindings ) {
					bindings.forEach( binding => {
						updateBoundObservableProperty( observable, binding.property );
					} );
				}
			} );
		}
	} );
}

/**
 * An interface which adds "observable properties" and data binding functionality.
 *
 * Can be easily implemented by a class by mixing the {@link module:utils/observablemixin~ObservableMixin} mixin.
 *
 * Read more about the usage of this interface in the:
 * * {@glink framework/guides/architecture/core-editor-architecture#event-system-and-observables Event system and observables}
 * section of the {@glink framework/guides/architecture/core-editor-architecture Core editor architecture} guide,
 * * {@glink framework/guides/deep-dive/observables Observables deep dive} guide.
 *
 * @interface Observable
 * @extends module:utils/emittermixin~Emitter
 */

/**
 * Fired when a property changed value.
 *
 *		observable.set( 'prop', 1 );
 *
 *		observable.on( 'change:prop', ( evt, propertyName, newValue, oldValue ) => {
 *			console.log( `${ propertyName } has changed from ${ oldValue } to ${ newValue }` );
 *		} );
 *
 *		observable.prop = 2; // -> 'prop has changed from 1 to 2'
 *
 * @event change:{property}
 * @param {String} name The property name.
 * @param {*} value The new property value.
 * @param {*} oldValue The previous property value.
 */

/**
 * Fired when a property value is going to be set but is not set yet (before the `change` event is fired).
 *
 * You can control the final value of the property by using
 * the {@link module:utils/eventinfo~EventInfo#return event's `return` property}.
 *
 *		observable.set( 'prop', 1 );
 *
 *		observable.on( 'set:prop', ( evt, propertyName, newValue, oldValue ) => {
 *			console.log( `Value is going to be changed from ${ oldValue } to ${ newValue }` );
 *			console.log( `Current property value is ${ observable[ propertyName ] }` );
 *
 *			// Let's override the value.
 *			evt.return = 3;
 *		} );
 *
 *		observable.on( 'change:prop', ( evt, propertyName, newValue, oldValue ) => {
 *			console.log( `Value has changed from ${ oldValue } to ${ newValue }` );
 *		} );
 *
 *		observable.prop = 2; // -> 'Value is going to be changed from 1 to 2'
 *		                     // -> 'Current property value is 1'
 *		                     // -> 'Value has changed from 1 to 3'
 *
 * **Note:** The event is fired even when the new value is the same as the old value.
 *
 * @event set:{property}
 * @param {String} name The property name.
 * @param {*} value The new property value.
 * @param {*} oldValue The previous property value.
 */

/**
 * Creates and sets the value of an observable property of this object. Such a property becomes a part
 * of the state and is observable.
 *
 * It accepts also a single object literal containing key/value pairs with properties to be set.
 *
 * This method throws the `observable-set-cannot-override` error if the observable instance already
 * has a property with the given property name. This prevents from mistakenly overriding existing
 * properties and methods, but means that `foo.set( 'bar', 1 )` may be slightly slower than `foo.bar = 1`.
 *
 * @method #set
 * @param {String|Object} name The property's name or object with `name=>value` pairs.
 * @param {*} [value] The property's value (if `name` was passed in the first parameter).
 */

/**
 * Binds {@link #set observable properties} to other objects implementing the
 * {@link module:utils/observablemixin~Observable} interface.
 *
 * Read more in the {@glink framework/guides/deep-dive/observables#property-bindings dedicated guide}
 * covering the topic of property bindings with some additional examples.
 *
 * Consider two objects: a `button` and an associated `command` (both `Observable`).
 *
 * A simple property binding could be as follows:
 *
 *		button.bind( 'isEnabled' ).to( command, 'isEnabled' );
 *
 * or even shorter:
 *
 *		button.bind( 'isEnabled' ).to( command );
 *
 * which works in the following way:
 *
 * * `button.isEnabled` **instantly equals** `command.isEnabled`,
 * * whenever `command.isEnabled` changes, `button.isEnabled` will immediately reflect its value.
 *
 * **Note**: To release the binding, use {@link module:utils/observablemixin~Observable#unbind}.
 *
 * You can also "rename" the property in the binding by specifying the new name in the `to()` chain:
 *
 *		button.bind( 'isEnabled' ).to( command, 'isWorking' );
 *
 * It is possible to bind more than one property at a time to shorten the code:
 *
 *		button.bind( 'isEnabled', 'value' ).to( command );
 *
 * which corresponds to:
 *
 *		button.bind( 'isEnabled' ).to( command );
 *		button.bind( 'value' ).to( command );
 *
 * The binding can include more than one observable, combining multiple data sources in a custom callback:
 *
 *		button.bind( 'isEnabled' ).to( command, 'isEnabled', ui, 'isVisible',
 *			( isCommandEnabled, isUIVisible ) => isCommandEnabled && isUIVisible );
 *
 * Using a custom callback allows processing the value before passing it to the target property:
 *
 *		button.bind( 'isEnabled' ).to( command, 'value', value => value === 'heading1' );
 *
 * It is also possible to bind to the same property in an array of observables.
 * To bind a `button` to multiple commands (also `Observables`) so that each and every one of them
 * must be enabled for the button to become enabled, use the following code:
 *
 *		button.bind( 'isEnabled' ).toMany( [ commandA, commandB, commandC ], 'isEnabled',
 *			( isAEnabled, isBEnabled, isCEnabled ) => isAEnabled && isBEnabled && isCEnabled );
 *
 * @method #bind
 * @param {...String} bindProperties Observable properties that will be bound to other observable(s).
 * @returns {Object} The bind chain with the `to()` and `toMany()` methods.
 */

/**
 * Removes the binding created with {@link #bind}.
 *
 *		// Removes the binding for the 'a' property.
 *		A.unbind( 'a' );
 *
 *		// Removes bindings for all properties.
 *		A.unbind();
 *
 * @method #unbind
 * @param {...String} [unbindProperties] Observable properties to be unbound. All the bindings will
 * be released if no properties are provided.
 */

/**
 * Turns the given methods of this object into event-based ones. This means that the new method will fire an event
 * (named after the method) and the original action will be plugged as a listener to that event.
 *
 * Read more in the {@glink framework/guides/deep-dive/observables#decorating-object-methods dedicated guide}
 * covering the topic of decorating methods with some additional examples.
 *
 * Decorating the method does not change its behavior (it only adds an event),
 * but it allows to modify it later on by listening to the method's event.
 *
 * For example, to cancel the method execution the event can be {@link module:utils/eventinfo~EventInfo#stop stopped}:
 *
 *		class Foo {
 *			constructor() {
 *				this.decorate( 'method' );
 *			}
 *
 *			method() {
 *				console.log( 'called!' );
 *			}
 *		}
 *
 *		const foo = new Foo();
 *		foo.on( 'method', ( evt ) => {
 *			evt.stop();
 *		}, { priority: 'high' } );
 *
 *		foo.method(); // Nothing is logged.
 *
 *
 * **Note**: The high {@link module:utils/priorities~PriorityString priority} listener
 * has been used to execute this particular callback before the one which calls the original method
 * (which uses the "normal" priority).
 *
 * It is also possible to change the returned value:
 *
 *		foo.on( 'method', ( evt ) => {
 *			evt.return = 'Foo!';
 *		} );
 *
 *		foo.method(); // -> 'Foo'
 *
 * Finally, it is possible to access and modify the arguments the method is called with:
 *
 *		method( a, b ) {
 *			console.log( `${ a }, ${ b }`  );
 *		}
 *
 *		// ...
 *
 *		foo.on( 'method', ( evt, args ) => {
 *			args[ 0 ] = 3;
 *
 *			console.log( args[ 1 ] ); // -> 2
 *		}, { priority: 'high' } );
 *
 *		foo.method( 1, 2 ); // -> '3, 2'
 *
 * @method #decorate
 * @param {String} methodName Name of the method to decorate.
 */


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/priorities.js":
/*!******************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/priorities.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/priorities
 */

/**
 * String representing a priority value.
 *
 * @typedef {'highest'|'high'|'normal'|'low'|'lowest'} module:utils/priorities~PriorityString
 */

/**
 * Provides group of constants to use instead of hardcoding numeric priority values.
 *
 * @namespace
 */
const priorities = {
	/**
	 * Converts a string with priority name to it's numeric value. If `Number` is given, it just returns it.
	 *
	 * @static
	 * @param {module:utils/priorities~PriorityString|Number} priority Priority to convert.
	 * @returns {Number} Converted priority.
	 */
	get( priority ) {
		if ( typeof priority != 'number' ) {
			return this[ priority ] || this.normal;
		} else {
			return priority;
		}
	},

	highest: 100000,
	high: 1000,
	normal: 0,
	low: -1000,
	lowest: -100000
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (priorities);


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/spy.js":
/*!***********************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/spy.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/spy
 */

/**
 * Creates a spy function (ala Sinon.js) that can be used to inspect call to it.
 *
 * The following are the present features:
 *
 * * spy.called: property set to `true` if the function has been called at least once.
 *
 * @returns {Function} The spy function.
 */
function spy() {
	return function spy() {
		spy.called = true;
	};
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (spy);


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/uid.js":
/*!***********************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/uid.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ uid)
/* harmony export */ });
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/uid
 */

// A hash table of hex numbers to avoid using toString() in uid() which is costly.
// [ '00', '01', '02', ..., 'fe', 'ff' ]
const HEX_NUMBERS = new Array( 256 ).fill()
	.map( ( val, index ) => ( '0' + ( index ).toString( 16 ) ).slice( -2 ) );

/**
 * Returns a unique id. The id starts with an "e" character and a randomly generated string of
 * 32 alphanumeric characters.
 *
 * **Note**: The characters the unique id is built from correspond to the hex number notation
 * (from "0" to "9", from "a" to "f"). In other words, each id corresponds to an "e" followed
 * by 16 8-bit numbers next to each other.
 *
 * @returns {String} An unique id string.
 */
function uid() {
	// Let's create some positive random 32bit integers first.
	//
	// 1. Math.random() is a float between 0 and 1.
	// 2. 0x100000000 is 2^32 = 4294967296.
	// 3. >>> 0 enforces integer (in JS all numbers are floating point).
	//
	// For instance:
	//		Math.random() * 0x100000000 = 3366450031.853859
	// but
	//		Math.random() * 0x100000000 >>> 0 = 3366450031.
	const r1 = Math.random() * 0x100000000 >>> 0;
	const r2 = Math.random() * 0x100000000 >>> 0;
	const r3 = Math.random() * 0x100000000 >>> 0;
	const r4 = Math.random() * 0x100000000 >>> 0;

	// Make sure that id does not start with number.
	return 'e' +
		HEX_NUMBERS[ r1 >> 0 & 0xFF ] +
		HEX_NUMBERS[ r1 >> 8 & 0xFF ] +
		HEX_NUMBERS[ r1 >> 16 & 0xFF ] +
		HEX_NUMBERS[ r1 >> 24 & 0xFF ] +
		HEX_NUMBERS[ r2 >> 0 & 0xFF ] +
		HEX_NUMBERS[ r2 >> 8 & 0xFF ] +
		HEX_NUMBERS[ r2 >> 16 & 0xFF ] +
		HEX_NUMBERS[ r2 >> 24 & 0xFF ] +
		HEX_NUMBERS[ r3 >> 0 & 0xFF ] +
		HEX_NUMBERS[ r3 >> 8 & 0xFF ] +
		HEX_NUMBERS[ r3 >> 16 & 0xFF ] +
		HEX_NUMBERS[ r3 >> 24 & 0xFF ] +
		HEX_NUMBERS[ r4 >> 0 & 0xFF ] +
		HEX_NUMBERS[ r4 >> 8 & 0xFF ] +
		HEX_NUMBERS[ r4 >> 16 & 0xFF ] +
		HEX_NUMBERS[ r4 >> 24 & 0xFF ];
}


/***/ }),

/***/ "./node_modules/@ckeditor/ckeditor5-utils/src/version.js":
/*!***************************************************************!*\
  !*** ./node_modules/@ckeditor/ckeditor5-utils/src/version.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ckeditorerror__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ckeditorerror */ "./node_modules/@ckeditor/ckeditor5-utils/src/ckeditorerror.js");
/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * @module utils/version
 */

/* globals window, global */



const version = '29.1.0';

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (version);

/* istanbul ignore next */
const windowOrGlobal = typeof window === 'object' ? window : __webpack_require__.g;

/* istanbul ignore next */
if ( windowOrGlobal.CKEDITOR_VERSION ) {
	/**
	 * This error is thrown when due to a mistake in how CKEditor 5 was installed or initialized, some
	 * of its modules were duplicated (evaluated and executed twice). Module duplication leads to inevitable runtime
	 * errors.
	 *
	 * There are many situations in which some modules can be loaded twice. In the worst case scenario,
	 * you may need to check your project for each of these issues and fix them all.
	 *
	 * # Trying to add a plugin to an existing build
	 *
	 * If you import an existing CKEditor 5 build and a plugin like this:
	 *
	 *		import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
	 *		import Highlight from '@ckeditor/ckeditor5-highlight/src/highlight';
	 *
	 * Then your project loads some CKEditor 5 packages twice. How does it happen?
	 *
	 * The build package contains a file which is already compiled with webpack. This means
	 * that it contains all the necessary code from e.g. `@ckeditor/ckeditor5-engine` and `@ckeditor/ckeditor5-utils`.
	 *
	 * However, the `Highlight` plugin imports some of the modules from these packages, too. If you ask webpack to
	 * build such a project, you will end up with the modules being included (and run) twice &mdash; first, because they are
	 * included inside the build package, and second, because they are required by the `Highlight` plugin.
	 *
	 * Therefore, **you must never add plugins to an existing build** unless your plugin has no dependencies.
	 *
	 * Adding plugins to a build is done by taking the source version of this build (so, before it was built with webpack)
	 * and adding plugins there. In this situation, webpack will know that it only needs to load each plugin once.
	 *
	 * Read more in the {@glink builds/guides/integration/installing-plugins "Installing plugins"} guide.
	 *
	 * # Confused an editor build with an editor implementation
	 *
	 * This scenario is very similar to the previous one, but has a different origin.
	 *
	 * Let's assume that you wanted to use CKEditor 5 from source, as explained in the
	 * {@glink builds/guides/integration/advanced-setup#scenario-2-building-from-source "Building from source"} section
	 * or in the {@glink framework/guides/quick-start "Quick start"} guide of CKEditor 5 Framework.
	 *
	 * The correct way to do so is to import an editor and plugins and run them together like this:
	 *
	 *		import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
	 *		import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';
	 *		import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
	 *		import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
	 *		import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
	 *
	 *		ClassicEditor
	 *			.create( document.querySelector( '#editor' ), {
	 *				plugins: [ Essentials, Paragraph, Bold, Italic ],
	 *				toolbar: [ 'bold', 'italic' ]
	 *			} )
	 *			.then( editor => {
	 *				console.log( 'Editor was initialized', editor );
	 *			} )
	 *			.catch( error => {
	 *				console.error( error.stack );
	 *			} );
	 *
	 * However, you might have mistakenly imported a build instead of the source `ClassicEditor`. In this case
	 * your imports will look like this:
	 *
	 *		import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
	 *		import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';
	 *		import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
	 *		import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
	 *		import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
	 *
	 * This creates the same situation as in the previous section because you use a build together with source plugins.
	 *
	 * Remember: `@ckeditor/ckeditor5-build-*` packages contain editor builds and `@ckeditor/ckeditor5-editor-*` contain source editors.
	 *
	 * # Loading two or more builds on one page
	 *
	 * If you use CKEditor 5 builds, you might have loaded two (or more) `ckeditor.js` files on one web page.
	 * Check your web page for duplicated `<script>` elements or make sure your page builder/bundler includes CKEditor only once.
	 *
	 * If you want to use two different types of editors at once, see the
	 * {@glink builds/guides/integration/advanced-setup#scenario-3-using-two-different-editors "Using two different editors"}
	 * section.
	 *
	 * # Using outdated packages
	 *
	 * Building CKEditor 5 from source requires using multiple npm packages. These packages have their dependencies
	 * to other packages. If you use the latest version of, for example, `@ckeditor/ckeditor5-editor-classic` with
	 * an outdated version of `@ckeditor/ckeditor5-image`, npm or yarn will need to install two different versions of
	 * `@ckeditor/ckeditor5-core` because `@ckeditor/ckeditor5-editor-classic` and `@ckeditor/ckeditor5-image` may require
	 * different versions of the core package.
	 *
	 * The solution to this issue is to update all packages to their latest version. We recommend
	 * using tools like [`npm-check-updates`](https://www.npmjs.com/package/npm-check-updates) which simplify this process.
	 *
	 * # Conflicting version of dependencies
	 *
	 * This is a special case of the previous scenario. If you use CKEditor 5 with some third-party plugins,
	 * it may happen that even if you use the latest versions of the official packages and the latest version of
	 * these third-party packages, there will be a conflict between some of their dependencies.
	 *
	 * Such a problem can be resolved by either downgrading CKEditor 5 packages (which we do not recommend) or
	 * asking the author of the third-party package to upgrade its depdendencies (or forking their project and doing this yourself).
	 *
	 * **Note:** All official CKEditor 5 packages (excluding integrations and `ckeditor5-dev-*` packages) are released in the
	 * same major version. This is &mdash; in the `x.y.z`, the `x` is the same for all packages. This is the simplest way to check
	 * whether you use packages coming from the same CKEditor 5 version. You can read more about versioning in the
	 * {@glink framework/guides/support/versioning-policy Versioning policy} guide.
	 *
	 * # Packages were duplicated in `node_modules`
	 *
	 * In some situations, especially when calling `npm install` multiple times, it may happen
	 * that npm will not correctly "deduplicate" packages.
	 *
	 * Normally, npm deduplicates all packages so, for example, `@ckeditor/ckeditor5-core` is installed only once in `node_modules/`.
	 * However, it is known to fail to do so from time to time.
	 *
	 * We recommend checking if any of the steps listed below help:
	 *
	 * * `rm -rf node_modules && npm install` to make sure you have a clean `node_modules/` directory. This step
	 * is known to help in most cases.
	 * * If you use `yarn.lock` or `package-lock.json`, remove it before `npm install`.
	 * * Check whether all CKEditor 5 packages are up to date and reinstall them
	 * if you changed anything (`rm -rf node_modules && npm install`).
	 *
	 * If all packages are correct and compatible with each other, the steps above are known to help. If not, you may
	 * try to check with `npm ls` how many times packages like `@ckeditor/ckeditor5-core`, `@ckeditor/ckeditor5-engine` and
	 *`@ckeditor/ckeditor5-utils` are installed. If more than once, verify which package causes that.
	 *
	 * @error ckeditor-duplicated-modules
	 */
	throw new _ckeditorerror__WEBPACK_IMPORTED_MODULE_0__.default(
		'ckeditor-duplicated-modules',
		null
	);
} else {
	windowOrGlobal.CKEDITOR_VERSION = version;
}


/***/ }),

/***/ "./resources/sass/icons.scss":
/*!***********************************!*\
  !*** ./resources/sass/icons.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/libraries.scss":
/*!***************************************!*\
  !*** ./resources/sass/libraries.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/lodash-es/_Symbol.js":
/*!*******************************************!*\
  !*** ./node_modules/lodash-es/_Symbol.js ***!
  \*******************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _root_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_root.js */ "./node_modules/lodash-es/_root.js");


/** Built-in value references. */
var Symbol = _root_js__WEBPACK_IMPORTED_MODULE_0__.default.Symbol;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Symbol);


/***/ }),

/***/ "./node_modules/lodash-es/_apply.js":
/*!******************************************!*\
  !*** ./node_modules/lodash-es/_apply.js ***!
  \******************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * A faster alternative to `Function#apply`, this function invokes `func`
 * with the `this` binding of `thisArg` and the arguments of `args`.
 *
 * @private
 * @param {Function} func The function to invoke.
 * @param {*} thisArg The `this` binding of `func`.
 * @param {Array} args The arguments to invoke `func` with.
 * @returns {*} Returns the result of `func`.
 */
function apply(func, thisArg, args) {
  switch (args.length) {
    case 0: return func.call(thisArg);
    case 1: return func.call(thisArg, args[0]);
    case 2: return func.call(thisArg, args[0], args[1]);
    case 3: return func.call(thisArg, args[0], args[1], args[2]);
  }
  return func.apply(thisArg, args);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (apply);


/***/ }),

/***/ "./node_modules/lodash-es/_arrayLikeKeys.js":
/*!**************************************************!*\
  !*** ./node_modules/lodash-es/_arrayLikeKeys.js ***!
  \**************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseTimes_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./_baseTimes.js */ "./node_modules/lodash-es/_baseTimes.js");
/* harmony import */ var _isArguments_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./isArguments.js */ "./node_modules/lodash-es/isArguments.js");
/* harmony import */ var _isArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isArray.js */ "./node_modules/lodash-es/isArray.js");
/* harmony import */ var _isBuffer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isBuffer.js */ "./node_modules/lodash-es/isBuffer.js");
/* harmony import */ var _isIndex_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./_isIndex.js */ "./node_modules/lodash-es/_isIndex.js");
/* harmony import */ var _isTypedArray_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./isTypedArray.js */ "./node_modules/lodash-es/isTypedArray.js");







/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Creates an array of the enumerable property names of the array-like `value`.
 *
 * @private
 * @param {*} value The value to query.
 * @param {boolean} inherited Specify returning inherited property names.
 * @returns {Array} Returns the array of property names.
 */
function arrayLikeKeys(value, inherited) {
  var isArr = (0,_isArray_js__WEBPACK_IMPORTED_MODULE_0__.default)(value),
      isArg = !isArr && (0,_isArguments_js__WEBPACK_IMPORTED_MODULE_1__.default)(value),
      isBuff = !isArr && !isArg && (0,_isBuffer_js__WEBPACK_IMPORTED_MODULE_2__.default)(value),
      isType = !isArr && !isArg && !isBuff && (0,_isTypedArray_js__WEBPACK_IMPORTED_MODULE_3__.default)(value),
      skipIndexes = isArr || isArg || isBuff || isType,
      result = skipIndexes ? (0,_baseTimes_js__WEBPACK_IMPORTED_MODULE_4__.default)(value.length, String) : [],
      length = result.length;

  for (var key in value) {
    if ((inherited || hasOwnProperty.call(value, key)) &&
        !(skipIndexes && (
           // Safari 9 has enumerable `arguments.length` in strict mode.
           key == 'length' ||
           // Node.js 0.10 has enumerable non-index properties on buffers.
           (isBuff && (key == 'offset' || key == 'parent')) ||
           // PhantomJS 2 has enumerable non-index properties on typed arrays.
           (isType && (key == 'buffer' || key == 'byteLength' || key == 'byteOffset')) ||
           // Skip index properties.
           (0,_isIndex_js__WEBPACK_IMPORTED_MODULE_5__.default)(key, length)
        ))) {
      result.push(key);
    }
  }
  return result;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (arrayLikeKeys);


/***/ }),

/***/ "./node_modules/lodash-es/_assignValue.js":
/*!************************************************!*\
  !*** ./node_modules/lodash-es/_assignValue.js ***!
  \************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseAssignValue_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_baseAssignValue.js */ "./node_modules/lodash-es/_baseAssignValue.js");
/* harmony import */ var _eq_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./eq.js */ "./node_modules/lodash-es/eq.js");



/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Assigns `value` to `key` of `object` if the existing value is not equivalent
 * using [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
 * for equality comparisons.
 *
 * @private
 * @param {Object} object The object to modify.
 * @param {string} key The key of the property to assign.
 * @param {*} value The value to assign.
 */
function assignValue(object, key, value) {
  var objValue = object[key];
  if (!(hasOwnProperty.call(object, key) && (0,_eq_js__WEBPACK_IMPORTED_MODULE_0__.default)(objValue, value)) ||
      (value === undefined && !(key in object))) {
    (0,_baseAssignValue_js__WEBPACK_IMPORTED_MODULE_1__.default)(object, key, value);
  }
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (assignValue);


/***/ }),

/***/ "./node_modules/lodash-es/_baseAssignValue.js":
/*!****************************************************!*\
  !*** ./node_modules/lodash-es/_baseAssignValue.js ***!
  \****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _defineProperty_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_defineProperty.js */ "./node_modules/lodash-es/_defineProperty.js");


/**
 * The base implementation of `assignValue` and `assignMergeValue` without
 * value checks.
 *
 * @private
 * @param {Object} object The object to modify.
 * @param {string} key The key of the property to assign.
 * @param {*} value The value to assign.
 */
function baseAssignValue(object, key, value) {
  if (key == '__proto__' && _defineProperty_js__WEBPACK_IMPORTED_MODULE_0__.default) {
    (0,_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__.default)(object, key, {
      'configurable': true,
      'enumerable': true,
      'value': value,
      'writable': true
    });
  } else {
    object[key] = value;
  }
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseAssignValue);


/***/ }),

/***/ "./node_modules/lodash-es/_baseGetTag.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/_baseGetTag.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Symbol_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_Symbol.js */ "./node_modules/lodash-es/_Symbol.js");
/* harmony import */ var _getRawTag_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_getRawTag.js */ "./node_modules/lodash-es/_getRawTag.js");
/* harmony import */ var _objectToString_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_objectToString.js */ "./node_modules/lodash-es/_objectToString.js");




/** `Object#toString` result references. */
var nullTag = '[object Null]',
    undefinedTag = '[object Undefined]';

/** Built-in value references. */
var symToStringTag = _Symbol_js__WEBPACK_IMPORTED_MODULE_0__.default ? _Symbol_js__WEBPACK_IMPORTED_MODULE_0__.default.toStringTag : undefined;

/**
 * The base implementation of `getTag` without fallbacks for buggy environments.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  if (value == null) {
    return value === undefined ? undefinedTag : nullTag;
  }
  return (symToStringTag && symToStringTag in Object(value))
    ? (0,_getRawTag_js__WEBPACK_IMPORTED_MODULE_1__.default)(value)
    : (0,_objectToString_js__WEBPACK_IMPORTED_MODULE_2__.default)(value);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseGetTag);


/***/ }),

/***/ "./node_modules/lodash-es/_baseIsArguments.js":
/*!****************************************************!*\
  !*** ./node_modules/lodash-es/_baseIsArguments.js ***!
  \****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseGetTag_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_baseGetTag.js */ "./node_modules/lodash-es/_baseGetTag.js");
/* harmony import */ var _isObjectLike_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isObjectLike.js */ "./node_modules/lodash-es/isObjectLike.js");



/** `Object#toString` result references. */
var argsTag = '[object Arguments]';

/**
 * The base implementation of `_.isArguments`.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
 */
function baseIsArguments(value) {
  return (0,_isObjectLike_js__WEBPACK_IMPORTED_MODULE_0__.default)(value) && (0,_baseGetTag_js__WEBPACK_IMPORTED_MODULE_1__.default)(value) == argsTag;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseIsArguments);


/***/ }),

/***/ "./node_modules/lodash-es/_baseIsNative.js":
/*!*************************************************!*\
  !*** ./node_modules/lodash-es/_baseIsNative.js ***!
  \*************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _isFunction_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./isFunction.js */ "./node_modules/lodash-es/isFunction.js");
/* harmony import */ var _isMasked_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_isMasked.js */ "./node_modules/lodash-es/_isMasked.js");
/* harmony import */ var _isObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isObject.js */ "./node_modules/lodash-es/isObject.js");
/* harmony import */ var _toSource_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./_toSource.js */ "./node_modules/lodash-es/_toSource.js");





/**
 * Used to match `RegExp`
 * [syntax characters](http://ecma-international.org/ecma-262/7.0/#sec-patterns).
 */
var reRegExpChar = /[\\^$.*+?()[\]{}|]/g;

/** Used to detect host constructors (Safari). */
var reIsHostCtor = /^\[object .+?Constructor\]$/;

/** Used for built-in method references. */
var funcProto = Function.prototype,
    objectProto = Object.prototype;

/** Used to resolve the decompiled source of functions. */
var funcToString = funcProto.toString;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/** Used to detect if a method is native. */
var reIsNative = RegExp('^' +
  funcToString.call(hasOwnProperty).replace(reRegExpChar, '\\$&')
  .replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$'
);

/**
 * The base implementation of `_.isNative` without bad shim checks.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a native function,
 *  else `false`.
 */
function baseIsNative(value) {
  if (!(0,_isObject_js__WEBPACK_IMPORTED_MODULE_0__.default)(value) || (0,_isMasked_js__WEBPACK_IMPORTED_MODULE_1__.default)(value)) {
    return false;
  }
  var pattern = (0,_isFunction_js__WEBPACK_IMPORTED_MODULE_2__.default)(value) ? reIsNative : reIsHostCtor;
  return pattern.test((0,_toSource_js__WEBPACK_IMPORTED_MODULE_3__.default)(value));
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseIsNative);


/***/ }),

/***/ "./node_modules/lodash-es/_baseIsTypedArray.js":
/*!*****************************************************!*\
  !*** ./node_modules/lodash-es/_baseIsTypedArray.js ***!
  \*****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseGetTag_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_baseGetTag.js */ "./node_modules/lodash-es/_baseGetTag.js");
/* harmony import */ var _isLength_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./isLength.js */ "./node_modules/lodash-es/isLength.js");
/* harmony import */ var _isObjectLike_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isObjectLike.js */ "./node_modules/lodash-es/isObjectLike.js");




/** `Object#toString` result references. */
var argsTag = '[object Arguments]',
    arrayTag = '[object Array]',
    boolTag = '[object Boolean]',
    dateTag = '[object Date]',
    errorTag = '[object Error]',
    funcTag = '[object Function]',
    mapTag = '[object Map]',
    numberTag = '[object Number]',
    objectTag = '[object Object]',
    regexpTag = '[object RegExp]',
    setTag = '[object Set]',
    stringTag = '[object String]',
    weakMapTag = '[object WeakMap]';

var arrayBufferTag = '[object ArrayBuffer]',
    dataViewTag = '[object DataView]',
    float32Tag = '[object Float32Array]',
    float64Tag = '[object Float64Array]',
    int8Tag = '[object Int8Array]',
    int16Tag = '[object Int16Array]',
    int32Tag = '[object Int32Array]',
    uint8Tag = '[object Uint8Array]',
    uint8ClampedTag = '[object Uint8ClampedArray]',
    uint16Tag = '[object Uint16Array]',
    uint32Tag = '[object Uint32Array]';

/** Used to identify `toStringTag` values of typed arrays. */
var typedArrayTags = {};
typedArrayTags[float32Tag] = typedArrayTags[float64Tag] =
typedArrayTags[int8Tag] = typedArrayTags[int16Tag] =
typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] =
typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] =
typedArrayTags[uint32Tag] = true;
typedArrayTags[argsTag] = typedArrayTags[arrayTag] =
typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] =
typedArrayTags[dataViewTag] = typedArrayTags[dateTag] =
typedArrayTags[errorTag] = typedArrayTags[funcTag] =
typedArrayTags[mapTag] = typedArrayTags[numberTag] =
typedArrayTags[objectTag] = typedArrayTags[regexpTag] =
typedArrayTags[setTag] = typedArrayTags[stringTag] =
typedArrayTags[weakMapTag] = false;

/**
 * The base implementation of `_.isTypedArray` without Node.js optimizations.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
 */
function baseIsTypedArray(value) {
  return (0,_isObjectLike_js__WEBPACK_IMPORTED_MODULE_0__.default)(value) &&
    (0,_isLength_js__WEBPACK_IMPORTED_MODULE_1__.default)(value.length) && !!typedArrayTags[(0,_baseGetTag_js__WEBPACK_IMPORTED_MODULE_2__.default)(value)];
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseIsTypedArray);


/***/ }),

/***/ "./node_modules/lodash-es/_baseKeysIn.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/_baseKeysIn.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _isObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isObject.js */ "./node_modules/lodash-es/isObject.js");
/* harmony import */ var _isPrototype_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_isPrototype.js */ "./node_modules/lodash-es/_isPrototype.js");
/* harmony import */ var _nativeKeysIn_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_nativeKeysIn.js */ "./node_modules/lodash-es/_nativeKeysIn.js");




/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * The base implementation of `_.keysIn` which doesn't treat sparse arrays as dense.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 */
function baseKeysIn(object) {
  if (!(0,_isObject_js__WEBPACK_IMPORTED_MODULE_0__.default)(object)) {
    return (0,_nativeKeysIn_js__WEBPACK_IMPORTED_MODULE_1__.default)(object);
  }
  var isProto = (0,_isPrototype_js__WEBPACK_IMPORTED_MODULE_2__.default)(object),
      result = [];

  for (var key in object) {
    if (!(key == 'constructor' && (isProto || !hasOwnProperty.call(object, key)))) {
      result.push(key);
    }
  }
  return result;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseKeysIn);


/***/ }),

/***/ "./node_modules/lodash-es/_baseRest.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_baseRest.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _identity_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./identity.js */ "./node_modules/lodash-es/identity.js");
/* harmony import */ var _overRest_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_overRest.js */ "./node_modules/lodash-es/_overRest.js");
/* harmony import */ var _setToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_setToString.js */ "./node_modules/lodash-es/_setToString.js");




/**
 * The base implementation of `_.rest` which doesn't validate or coerce arguments.
 *
 * @private
 * @param {Function} func The function to apply a rest parameter to.
 * @param {number} [start=func.length-1] The start position of the rest parameter.
 * @returns {Function} Returns the new function.
 */
function baseRest(func, start) {
  return (0,_setToString_js__WEBPACK_IMPORTED_MODULE_0__.default)((0,_overRest_js__WEBPACK_IMPORTED_MODULE_1__.default)(func, start, _identity_js__WEBPACK_IMPORTED_MODULE_2__.default), func + '');
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseRest);


/***/ }),

/***/ "./node_modules/lodash-es/_baseSetToString.js":
/*!****************************************************!*\
  !*** ./node_modules/lodash-es/_baseSetToString.js ***!
  \****************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _constant_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constant.js */ "./node_modules/lodash-es/constant.js");
/* harmony import */ var _defineProperty_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_defineProperty.js */ "./node_modules/lodash-es/_defineProperty.js");
/* harmony import */ var _identity_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./identity.js */ "./node_modules/lodash-es/identity.js");




/**
 * The base implementation of `setToString` without support for hot loop shorting.
 *
 * @private
 * @param {Function} func The function to modify.
 * @param {Function} string The `toString` result.
 * @returns {Function} Returns `func`.
 */
var baseSetToString = !_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__.default ? _identity_js__WEBPACK_IMPORTED_MODULE_1__.default : function(func, string) {
  return (0,_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__.default)(func, 'toString', {
    'configurable': true,
    'enumerable': false,
    'value': (0,_constant_js__WEBPACK_IMPORTED_MODULE_2__.default)(string),
    'writable': true
  });
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseSetToString);


/***/ }),

/***/ "./node_modules/lodash-es/_baseTimes.js":
/*!**********************************************!*\
  !*** ./node_modules/lodash-es/_baseTimes.js ***!
  \**********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * The base implementation of `_.times` without support for iteratee shorthands
 * or max array length checks.
 *
 * @private
 * @param {number} n The number of times to invoke `iteratee`.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the array of results.
 */
function baseTimes(n, iteratee) {
  var index = -1,
      result = Array(n);

  while (++index < n) {
    result[index] = iteratee(index);
  }
  return result;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseTimes);


/***/ }),

/***/ "./node_modules/lodash-es/_baseUnary.js":
/*!**********************************************!*\
  !*** ./node_modules/lodash-es/_baseUnary.js ***!
  \**********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * The base implementation of `_.unary` without support for storing metadata.
 *
 * @private
 * @param {Function} func The function to cap arguments for.
 * @returns {Function} Returns the new capped function.
 */
function baseUnary(func) {
  return function(value) {
    return func(value);
  };
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (baseUnary);


/***/ }),

/***/ "./node_modules/lodash-es/_copyObject.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/_copyObject.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _assignValue_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_assignValue.js */ "./node_modules/lodash-es/_assignValue.js");
/* harmony import */ var _baseAssignValue_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_baseAssignValue.js */ "./node_modules/lodash-es/_baseAssignValue.js");



/**
 * Copies properties of `source` to `object`.
 *
 * @private
 * @param {Object} source The object to copy properties from.
 * @param {Array} props The property identifiers to copy.
 * @param {Object} [object={}] The object to copy properties to.
 * @param {Function} [customizer] The function to customize copied values.
 * @returns {Object} Returns `object`.
 */
function copyObject(source, props, object, customizer) {
  var isNew = !object;
  object || (object = {});

  var index = -1,
      length = props.length;

  while (++index < length) {
    var key = props[index];

    var newValue = customizer
      ? customizer(object[key], source[key], key, object, source)
      : undefined;

    if (newValue === undefined) {
      newValue = source[key];
    }
    if (isNew) {
      (0,_baseAssignValue_js__WEBPACK_IMPORTED_MODULE_0__.default)(object, key, newValue);
    } else {
      (0,_assignValue_js__WEBPACK_IMPORTED_MODULE_1__.default)(object, key, newValue);
    }
  }
  return object;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (copyObject);


/***/ }),

/***/ "./node_modules/lodash-es/_coreJsData.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/_coreJsData.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _root_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_root.js */ "./node_modules/lodash-es/_root.js");


/** Used to detect overreaching core-js shims. */
var coreJsData = _root_js__WEBPACK_IMPORTED_MODULE_0__.default["__core-js_shared__"];

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (coreJsData);


/***/ }),

/***/ "./node_modules/lodash-es/_createAssigner.js":
/*!***************************************************!*\
  !*** ./node_modules/lodash-es/_createAssigner.js ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseRest_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_baseRest.js */ "./node_modules/lodash-es/_baseRest.js");
/* harmony import */ var _isIterateeCall_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_isIterateeCall.js */ "./node_modules/lodash-es/_isIterateeCall.js");



/**
 * Creates a function like `_.assign`.
 *
 * @private
 * @param {Function} assigner The function to assign values.
 * @returns {Function} Returns the new assigner function.
 */
function createAssigner(assigner) {
  return (0,_baseRest_js__WEBPACK_IMPORTED_MODULE_0__.default)(function(object, sources) {
    var index = -1,
        length = sources.length,
        customizer = length > 1 ? sources[length - 1] : undefined,
        guard = length > 2 ? sources[2] : undefined;

    customizer = (assigner.length > 3 && typeof customizer == 'function')
      ? (length--, customizer)
      : undefined;

    if (guard && (0,_isIterateeCall_js__WEBPACK_IMPORTED_MODULE_1__.default)(sources[0], sources[1], guard)) {
      customizer = length < 3 ? undefined : customizer;
      length = 1;
    }
    object = Object(object);
    while (++index < length) {
      var source = sources[index];
      if (source) {
        assigner(object, source, index, customizer);
      }
    }
    return object;
  });
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (createAssigner);


/***/ }),

/***/ "./node_modules/lodash-es/_defineProperty.js":
/*!***************************************************!*\
  !*** ./node_modules/lodash-es/_defineProperty.js ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _getNative_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_getNative.js */ "./node_modules/lodash-es/_getNative.js");


var defineProperty = (function() {
  try {
    var func = (0,_getNative_js__WEBPACK_IMPORTED_MODULE_0__.default)(Object, 'defineProperty');
    func({}, '', {});
    return func;
  } catch (e) {}
}());

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (defineProperty);


/***/ }),

/***/ "./node_modules/lodash-es/_freeGlobal.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/_freeGlobal.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (freeGlobal);


/***/ }),

/***/ "./node_modules/lodash-es/_getNative.js":
/*!**********************************************!*\
  !*** ./node_modules/lodash-es/_getNative.js ***!
  \**********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseIsNative_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_baseIsNative.js */ "./node_modules/lodash-es/_baseIsNative.js");
/* harmony import */ var _getValue_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_getValue.js */ "./node_modules/lodash-es/_getValue.js");



/**
 * Gets the native function at `key` of `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @param {string} key The key of the method to get.
 * @returns {*} Returns the function if it's native, else `undefined`.
 */
function getNative(object, key) {
  var value = (0,_getValue_js__WEBPACK_IMPORTED_MODULE_0__.default)(object, key);
  return (0,_baseIsNative_js__WEBPACK_IMPORTED_MODULE_1__.default)(value) ? value : undefined;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (getNative);


/***/ }),

/***/ "./node_modules/lodash-es/_getRawTag.js":
/*!**********************************************!*\
  !*** ./node_modules/lodash-es/_getRawTag.js ***!
  \**********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Symbol_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_Symbol.js */ "./node_modules/lodash-es/_Symbol.js");


/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/** Built-in value references. */
var symToStringTag = _Symbol_js__WEBPACK_IMPORTED_MODULE_0__.default ? _Symbol_js__WEBPACK_IMPORTED_MODULE_0__.default.toStringTag : undefined;

/**
 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the raw `toStringTag`.
 */
function getRawTag(value) {
  var isOwn = hasOwnProperty.call(value, symToStringTag),
      tag = value[symToStringTag];

  try {
    value[symToStringTag] = undefined;
    var unmasked = true;
  } catch (e) {}

  var result = nativeObjectToString.call(value);
  if (unmasked) {
    if (isOwn) {
      value[symToStringTag] = tag;
    } else {
      delete value[symToStringTag];
    }
  }
  return result;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (getRawTag);


/***/ }),

/***/ "./node_modules/lodash-es/_getValue.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_getValue.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * Gets the value at `key` of `object`.
 *
 * @private
 * @param {Object} [object] The object to query.
 * @param {string} key The key of the property to get.
 * @returns {*} Returns the property value.
 */
function getValue(object, key) {
  return object == null ? undefined : object[key];
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (getValue);


/***/ }),

/***/ "./node_modules/lodash-es/_isIndex.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/_isIndex.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Used as references for various `Number` constants. */
var MAX_SAFE_INTEGER = 9007199254740991;

/** Used to detect unsigned integer values. */
var reIsUint = /^(?:0|[1-9]\d*)$/;

/**
 * Checks if `value` is a valid array-like index.
 *
 * @private
 * @param {*} value The value to check.
 * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
 * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
 */
function isIndex(value, length) {
  var type = typeof value;
  length = length == null ? MAX_SAFE_INTEGER : length;

  return !!length &&
    (type == 'number' ||
      (type != 'symbol' && reIsUint.test(value))) &&
        (value > -1 && value % 1 == 0 && value < length);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isIndex);


/***/ }),

/***/ "./node_modules/lodash-es/_isIterateeCall.js":
/*!***************************************************!*\
  !*** ./node_modules/lodash-es/_isIterateeCall.js ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _eq_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./eq.js */ "./node_modules/lodash-es/eq.js");
/* harmony import */ var _isArrayLike_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./isArrayLike.js */ "./node_modules/lodash-es/isArrayLike.js");
/* harmony import */ var _isIndex_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_isIndex.js */ "./node_modules/lodash-es/_isIndex.js");
/* harmony import */ var _isObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isObject.js */ "./node_modules/lodash-es/isObject.js");





/**
 * Checks if the given arguments are from an iteratee call.
 *
 * @private
 * @param {*} value The potential iteratee value argument.
 * @param {*} index The potential iteratee index or key argument.
 * @param {*} object The potential iteratee object argument.
 * @returns {boolean} Returns `true` if the arguments are from an iteratee call,
 *  else `false`.
 */
function isIterateeCall(value, index, object) {
  if (!(0,_isObject_js__WEBPACK_IMPORTED_MODULE_0__.default)(object)) {
    return false;
  }
  var type = typeof index;
  if (type == 'number'
        ? ((0,_isArrayLike_js__WEBPACK_IMPORTED_MODULE_1__.default)(object) && (0,_isIndex_js__WEBPACK_IMPORTED_MODULE_2__.default)(index, object.length))
        : (type == 'string' && index in object)
      ) {
    return (0,_eq_js__WEBPACK_IMPORTED_MODULE_3__.default)(object[index], value);
  }
  return false;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isIterateeCall);


/***/ }),

/***/ "./node_modules/lodash-es/_isMasked.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_isMasked.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _coreJsData_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_coreJsData.js */ "./node_modules/lodash-es/_coreJsData.js");


/** Used to detect methods masquerading as native. */
var maskSrcKey = (function() {
  var uid = /[^.]+$/.exec(_coreJsData_js__WEBPACK_IMPORTED_MODULE_0__.default && _coreJsData_js__WEBPACK_IMPORTED_MODULE_0__.default.keys && _coreJsData_js__WEBPACK_IMPORTED_MODULE_0__.default.keys.IE_PROTO || '');
  return uid ? ('Symbol(src)_1.' + uid) : '';
}());

/**
 * Checks if `func` has its source masked.
 *
 * @private
 * @param {Function} func The function to check.
 * @returns {boolean} Returns `true` if `func` is masked, else `false`.
 */
function isMasked(func) {
  return !!maskSrcKey && (maskSrcKey in func);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isMasked);


/***/ }),

/***/ "./node_modules/lodash-es/_isPrototype.js":
/*!************************************************!*\
  !*** ./node_modules/lodash-es/_isPrototype.js ***!
  \************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Checks if `value` is likely a prototype object.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a prototype, else `false`.
 */
function isPrototype(value) {
  var Ctor = value && value.constructor,
      proto = (typeof Ctor == 'function' && Ctor.prototype) || objectProto;

  return value === proto;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isPrototype);


/***/ }),

/***/ "./node_modules/lodash-es/_nativeKeysIn.js":
/*!*************************************************!*\
  !*** ./node_modules/lodash-es/_nativeKeysIn.js ***!
  \*************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * This function is like
 * [`Object.keys`](http://ecma-international.org/ecma-262/7.0/#sec-object.keys)
 * except that it includes inherited enumerable properties.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 */
function nativeKeysIn(object) {
  var result = [];
  if (object != null) {
    for (var key in Object(object)) {
      result.push(key);
    }
  }
  return result;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (nativeKeysIn);


/***/ }),

/***/ "./node_modules/lodash-es/_nodeUtil.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_nodeUtil.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _freeGlobal_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_freeGlobal.js */ "./node_modules/lodash-es/_freeGlobal.js");


/** Detect free variable `exports`. */
var freeExports = typeof exports == 'object' && exports && !exports.nodeType && exports;

/** Detect free variable `module`. */
var freeModule = freeExports && typeof module == 'object' && module && !module.nodeType && module;

/** Detect the popular CommonJS extension `module.exports`. */
var moduleExports = freeModule && freeModule.exports === freeExports;

/** Detect free variable `process` from Node.js. */
var freeProcess = moduleExports && _freeGlobal_js__WEBPACK_IMPORTED_MODULE_0__.default.process;

/** Used to access faster Node.js helpers. */
var nodeUtil = (function() {
  try {
    // Use `util.types` for Node.js 10+.
    var types = freeModule && freeModule.require && freeModule.require('util').types;

    if (types) {
      return types;
    }

    // Legacy `process.binding('util')` for Node.js < 10.
    return freeProcess && freeProcess.binding && freeProcess.binding('util');
  } catch (e) {}
}());

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (nodeUtil);


/***/ }),

/***/ "./node_modules/lodash-es/_objectToString.js":
/*!***************************************************!*\
  !*** ./node_modules/lodash-es/_objectToString.js ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/**
 * Converts `value` to a string using `Object.prototype.toString`.
 *
 * @private
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 */
function objectToString(value) {
  return nativeObjectToString.call(value);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (objectToString);


/***/ }),

/***/ "./node_modules/lodash-es/_overRest.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_overRest.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _apply_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_apply.js */ "./node_modules/lodash-es/_apply.js");


/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeMax = Math.max;

/**
 * A specialized version of `baseRest` which transforms the rest array.
 *
 * @private
 * @param {Function} func The function to apply a rest parameter to.
 * @param {number} [start=func.length-1] The start position of the rest parameter.
 * @param {Function} transform The rest array transform.
 * @returns {Function} Returns the new function.
 */
function overRest(func, start, transform) {
  start = nativeMax(start === undefined ? (func.length - 1) : start, 0);
  return function() {
    var args = arguments,
        index = -1,
        length = nativeMax(args.length - start, 0),
        array = Array(length);

    while (++index < length) {
      array[index] = args[start + index];
    }
    index = -1;
    var otherArgs = Array(start + 1);
    while (++index < start) {
      otherArgs[index] = args[index];
    }
    otherArgs[start] = transform(array);
    return (0,_apply_js__WEBPACK_IMPORTED_MODULE_0__.default)(func, this, otherArgs);
  };
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (overRest);


/***/ }),

/***/ "./node_modules/lodash-es/_root.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash-es/_root.js ***!
  \*****************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _freeGlobal_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_freeGlobal.js */ "./node_modules/lodash-es/_freeGlobal.js");


/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = _freeGlobal_js__WEBPACK_IMPORTED_MODULE_0__.default || freeSelf || Function('return this')();

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (root);


/***/ }),

/***/ "./node_modules/lodash-es/_setToString.js":
/*!************************************************!*\
  !*** ./node_modules/lodash-es/_setToString.js ***!
  \************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseSetToString_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_baseSetToString.js */ "./node_modules/lodash-es/_baseSetToString.js");
/* harmony import */ var _shortOut_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_shortOut.js */ "./node_modules/lodash-es/_shortOut.js");



/**
 * Sets the `toString` method of `func` to return `string`.
 *
 * @private
 * @param {Function} func The function to modify.
 * @param {Function} string The `toString` result.
 * @returns {Function} Returns `func`.
 */
var setToString = (0,_shortOut_js__WEBPACK_IMPORTED_MODULE_0__.default)(_baseSetToString_js__WEBPACK_IMPORTED_MODULE_1__.default);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (setToString);


/***/ }),

/***/ "./node_modules/lodash-es/_shortOut.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_shortOut.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Used to detect hot functions by number of calls within a span of milliseconds. */
var HOT_COUNT = 800,
    HOT_SPAN = 16;

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeNow = Date.now;

/**
 * Creates a function that'll short out and invoke `identity` instead
 * of `func` when it's called `HOT_COUNT` or more times in `HOT_SPAN`
 * milliseconds.
 *
 * @private
 * @param {Function} func The function to restrict.
 * @returns {Function} Returns the new shortable function.
 */
function shortOut(func) {
  var count = 0,
      lastCalled = 0;

  return function() {
    var stamp = nativeNow(),
        remaining = HOT_SPAN - (stamp - lastCalled);

    lastCalled = stamp;
    if (remaining > 0) {
      if (++count >= HOT_COUNT) {
        return arguments[0];
      }
    } else {
      count = 0;
    }
    return func.apply(undefined, arguments);
  };
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (shortOut);


/***/ }),

/***/ "./node_modules/lodash-es/_toSource.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/_toSource.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Used for built-in method references. */
var funcProto = Function.prototype;

/** Used to resolve the decompiled source of functions. */
var funcToString = funcProto.toString;

/**
 * Converts `func` to its source code.
 *
 * @private
 * @param {Function} func The function to convert.
 * @returns {string} Returns the source code.
 */
function toSource(func) {
  if (func != null) {
    try {
      return funcToString.call(func);
    } catch (e) {}
    try {
      return (func + '');
    } catch (e) {}
  }
  return '';
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (toSource);


/***/ }),

/***/ "./node_modules/lodash-es/assignIn.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/assignIn.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _copyObject_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_copyObject.js */ "./node_modules/lodash-es/_copyObject.js");
/* harmony import */ var _createAssigner_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_createAssigner.js */ "./node_modules/lodash-es/_createAssigner.js");
/* harmony import */ var _keysIn_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./keysIn.js */ "./node_modules/lodash-es/keysIn.js");




/**
 * This method is like `_.assign` except that it iterates over own and
 * inherited source properties.
 *
 * **Note:** This method mutates `object`.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @alias extend
 * @category Object
 * @param {Object} object The destination object.
 * @param {...Object} [sources] The source objects.
 * @returns {Object} Returns `object`.
 * @see _.assign
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 * }
 *
 * function Bar() {
 *   this.c = 3;
 * }
 *
 * Foo.prototype.b = 2;
 * Bar.prototype.d = 4;
 *
 * _.assignIn({ 'a': 0 }, new Foo, new Bar);
 * // => { 'a': 1, 'b': 2, 'c': 3, 'd': 4 }
 */
var assignIn = (0,_createAssigner_js__WEBPACK_IMPORTED_MODULE_0__.default)(function(object, source) {
  (0,_copyObject_js__WEBPACK_IMPORTED_MODULE_1__.default)(source, (0,_keysIn_js__WEBPACK_IMPORTED_MODULE_2__.default)(source), object);
});

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (assignIn);


/***/ }),

/***/ "./node_modules/lodash-es/constant.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/constant.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * Creates a function that returns `value`.
 *
 * @static
 * @memberOf _
 * @since 2.4.0
 * @category Util
 * @param {*} value The value to return from the new function.
 * @returns {Function} Returns the new constant function.
 * @example
 *
 * var objects = _.times(2, _.constant({ 'a': 1 }));
 *
 * console.log(objects);
 * // => [{ 'a': 1 }, { 'a': 1 }]
 *
 * console.log(objects[0] === objects[1]);
 * // => true
 */
function constant(value) {
  return function() {
    return value;
  };
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (constant);


/***/ }),

/***/ "./node_modules/lodash-es/eq.js":
/*!**************************************!*\
  !*** ./node_modules/lodash-es/eq.js ***!
  \**************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * Performs a
 * [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
 * comparison between two values to determine if they are equivalent.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to compare.
 * @param {*} other The other value to compare.
 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
 * @example
 *
 * var object = { 'a': 1 };
 * var other = { 'a': 1 };
 *
 * _.eq(object, object);
 * // => true
 *
 * _.eq(object, other);
 * // => false
 *
 * _.eq('a', 'a');
 * // => true
 *
 * _.eq('a', Object('a'));
 * // => false
 *
 * _.eq(NaN, NaN);
 * // => true
 */
function eq(value, other) {
  return value === other || (value !== value && other !== other);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (eq);


/***/ }),

/***/ "./node_modules/lodash-es/identity.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/identity.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * This method returns the first argument it receives.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Util
 * @param {*} value Any value.
 * @returns {*} Returns `value`.
 * @example
 *
 * var object = { 'a': 1 };
 *
 * console.log(_.identity(object) === object);
 * // => true
 */
function identity(value) {
  return value;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (identity);


/***/ }),

/***/ "./node_modules/lodash-es/isArguments.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/isArguments.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseIsArguments_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_baseIsArguments.js */ "./node_modules/lodash-es/_baseIsArguments.js");
/* harmony import */ var _isObjectLike_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./isObjectLike.js */ "./node_modules/lodash-es/isObjectLike.js");



/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/** Built-in value references. */
var propertyIsEnumerable = objectProto.propertyIsEnumerable;

/**
 * Checks if `value` is likely an `arguments` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
 *  else `false`.
 * @example
 *
 * _.isArguments(function() { return arguments; }());
 * // => true
 *
 * _.isArguments([1, 2, 3]);
 * // => false
 */
var isArguments = (0,_baseIsArguments_js__WEBPACK_IMPORTED_MODULE_0__.default)(function() { return arguments; }()) ? _baseIsArguments_js__WEBPACK_IMPORTED_MODULE_0__.default : function(value) {
  return (0,_isObjectLike_js__WEBPACK_IMPORTED_MODULE_1__.default)(value) && hasOwnProperty.call(value, 'callee') &&
    !propertyIsEnumerable.call(value, 'callee');
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isArguments);


/***/ }),

/***/ "./node_modules/lodash-es/isArray.js":
/*!*******************************************!*\
  !*** ./node_modules/lodash-es/isArray.js ***!
  \*******************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * Checks if `value` is classified as an `Array` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
 * @example
 *
 * _.isArray([1, 2, 3]);
 * // => true
 *
 * _.isArray(document.body.children);
 * // => false
 *
 * _.isArray('abc');
 * // => false
 *
 * _.isArray(_.noop);
 * // => false
 */
var isArray = Array.isArray;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isArray);


/***/ }),

/***/ "./node_modules/lodash-es/isArrayLike.js":
/*!***********************************************!*\
  !*** ./node_modules/lodash-es/isArrayLike.js ***!
  \***********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _isFunction_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./isFunction.js */ "./node_modules/lodash-es/isFunction.js");
/* harmony import */ var _isLength_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isLength.js */ "./node_modules/lodash-es/isLength.js");



/**
 * Checks if `value` is array-like. A value is considered array-like if it's
 * not a function and has a `value.length` that's an integer greater than or
 * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
 * @example
 *
 * _.isArrayLike([1, 2, 3]);
 * // => true
 *
 * _.isArrayLike(document.body.children);
 * // => true
 *
 * _.isArrayLike('abc');
 * // => true
 *
 * _.isArrayLike(_.noop);
 * // => false
 */
function isArrayLike(value) {
  return value != null && (0,_isLength_js__WEBPACK_IMPORTED_MODULE_0__.default)(value.length) && !(0,_isFunction_js__WEBPACK_IMPORTED_MODULE_1__.default)(value);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isArrayLike);


/***/ }),

/***/ "./node_modules/lodash-es/isBuffer.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/isBuffer.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _root_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_root.js */ "./node_modules/lodash-es/_root.js");
/* harmony import */ var _stubFalse_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./stubFalse.js */ "./node_modules/lodash-es/stubFalse.js");



/** Detect free variable `exports`. */
var freeExports = typeof exports == 'object' && exports && !exports.nodeType && exports;

/** Detect free variable `module`. */
var freeModule = freeExports && typeof module == 'object' && module && !module.nodeType && module;

/** Detect the popular CommonJS extension `module.exports`. */
var moduleExports = freeModule && freeModule.exports === freeExports;

/** Built-in value references. */
var Buffer = moduleExports ? _root_js__WEBPACK_IMPORTED_MODULE_0__.default.Buffer : undefined;

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeIsBuffer = Buffer ? Buffer.isBuffer : undefined;

/**
 * Checks if `value` is a buffer.
 *
 * @static
 * @memberOf _
 * @since 4.3.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a buffer, else `false`.
 * @example
 *
 * _.isBuffer(new Buffer(2));
 * // => true
 *
 * _.isBuffer(new Uint8Array(2));
 * // => false
 */
var isBuffer = nativeIsBuffer || _stubFalse_js__WEBPACK_IMPORTED_MODULE_1__.default;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isBuffer);


/***/ }),

/***/ "./node_modules/lodash-es/isFunction.js":
/*!**********************************************!*\
  !*** ./node_modules/lodash-es/isFunction.js ***!
  \**********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseGetTag_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_baseGetTag.js */ "./node_modules/lodash-es/_baseGetTag.js");
/* harmony import */ var _isObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isObject.js */ "./node_modules/lodash-es/isObject.js");



/** `Object#toString` result references. */
var asyncTag = '[object AsyncFunction]',
    funcTag = '[object Function]',
    genTag = '[object GeneratorFunction]',
    proxyTag = '[object Proxy]';

/**
 * Checks if `value` is classified as a `Function` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a function, else `false`.
 * @example
 *
 * _.isFunction(_);
 * // => true
 *
 * _.isFunction(/abc/);
 * // => false
 */
function isFunction(value) {
  if (!(0,_isObject_js__WEBPACK_IMPORTED_MODULE_0__.default)(value)) {
    return false;
  }
  // The use of `Object#toString` avoids issues with the `typeof` operator
  // in Safari 9 which returns 'object' for typed arrays and other constructors.
  var tag = (0,_baseGetTag_js__WEBPACK_IMPORTED_MODULE_1__.default)(value);
  return tag == funcTag || tag == genTag || tag == asyncTag || tag == proxyTag;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isFunction);


/***/ }),

/***/ "./node_modules/lodash-es/isLength.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/isLength.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/** Used as references for various `Number` constants. */
var MAX_SAFE_INTEGER = 9007199254740991;

/**
 * Checks if `value` is a valid array-like length.
 *
 * **Note:** This method is loosely based on
 * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
 * @example
 *
 * _.isLength(3);
 * // => true
 *
 * _.isLength(Number.MIN_VALUE);
 * // => false
 *
 * _.isLength(Infinity);
 * // => false
 *
 * _.isLength('3');
 * // => false
 */
function isLength(value) {
  return typeof value == 'number' &&
    value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isLength);


/***/ }),

/***/ "./node_modules/lodash-es/isObject.js":
/*!********************************************!*\
  !*** ./node_modules/lodash-es/isObject.js ***!
  \********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * Checks if `value` is the
 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(_.noop);
 * // => true
 *
 * _.isObject(null);
 * // => false
 */
function isObject(value) {
  var type = typeof value;
  return value != null && (type == 'object' || type == 'function');
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isObject);


/***/ }),

/***/ "./node_modules/lodash-es/isObjectLike.js":
/*!************************************************!*\
  !*** ./node_modules/lodash-es/isObjectLike.js ***!
  \************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return value != null && typeof value == 'object';
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isObjectLike);


/***/ }),

/***/ "./node_modules/lodash-es/isTypedArray.js":
/*!************************************************!*\
  !*** ./node_modules/lodash-es/isTypedArray.js ***!
  \************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _baseIsTypedArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_baseIsTypedArray.js */ "./node_modules/lodash-es/_baseIsTypedArray.js");
/* harmony import */ var _baseUnary_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_baseUnary.js */ "./node_modules/lodash-es/_baseUnary.js");
/* harmony import */ var _nodeUtil_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_nodeUtil.js */ "./node_modules/lodash-es/_nodeUtil.js");




/* Node.js helper references. */
var nodeIsTypedArray = _nodeUtil_js__WEBPACK_IMPORTED_MODULE_0__.default && _nodeUtil_js__WEBPACK_IMPORTED_MODULE_0__.default.isTypedArray;

/**
 * Checks if `value` is classified as a typed array.
 *
 * @static
 * @memberOf _
 * @since 3.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
 * @example
 *
 * _.isTypedArray(new Uint8Array);
 * // => true
 *
 * _.isTypedArray([]);
 * // => false
 */
var isTypedArray = nodeIsTypedArray ? (0,_baseUnary_js__WEBPACK_IMPORTED_MODULE_1__.default)(nodeIsTypedArray) : _baseIsTypedArray_js__WEBPACK_IMPORTED_MODULE_2__.default;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (isTypedArray);


/***/ }),

/***/ "./node_modules/lodash-es/keysIn.js":
/*!******************************************!*\
  !*** ./node_modules/lodash-es/keysIn.js ***!
  \******************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _arrayLikeKeys_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_arrayLikeKeys.js */ "./node_modules/lodash-es/_arrayLikeKeys.js");
/* harmony import */ var _baseKeysIn_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./_baseKeysIn.js */ "./node_modules/lodash-es/_baseKeysIn.js");
/* harmony import */ var _isArrayLike_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isArrayLike.js */ "./node_modules/lodash-es/isArrayLike.js");




/**
 * Creates an array of the own and inherited enumerable property names of `object`.
 *
 * **Note:** Non-object values are coerced to objects.
 *
 * @static
 * @memberOf _
 * @since 3.0.0
 * @category Object
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 *   this.b = 2;
 * }
 *
 * Foo.prototype.c = 3;
 *
 * _.keysIn(new Foo);
 * // => ['a', 'b', 'c'] (iteration order is not guaranteed)
 */
function keysIn(object) {
  return (0,_isArrayLike_js__WEBPACK_IMPORTED_MODULE_0__.default)(object) ? (0,_arrayLikeKeys_js__WEBPACK_IMPORTED_MODULE_1__.default)(object, true) : (0,_baseKeysIn_js__WEBPACK_IMPORTED_MODULE_2__.default)(object);
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (keysIn);


/***/ }),

/***/ "./node_modules/lodash-es/stubFalse.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash-es/stubFalse.js ***!
  \*********************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * This method returns `false`.
 *
 * @static
 * @memberOf _
 * @since 4.13.0
 * @category Util
 * @returns {boolean} Returns `false`.
 * @example
 *
 * _.times(2, _.stubFalse);
 * // => [false, false]
 */
function stubFalse() {
  return false;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (stubFalse);


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
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
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
/******/ 			"/admin/assets/libs/simpleuploadadapter": 0,
/******/ 			"css/libraries": 0,
/******/ 			"css/app": 0,
/******/ 			"css/icons": 0
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
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/libraries","css/app","css/icons"], () => (__webpack_require__("./node_modules/@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter.js")))
/******/ 	__webpack_require__.O(undefined, ["css/libraries","css/app","css/icons"], () => (__webpack_require__("./resources/sass/icons.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/libraries","css/app","css/icons"], () => (__webpack_require__("./resources/sass/libraries.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/libraries","css/app","css/icons"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;