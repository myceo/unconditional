// Global CDN, use source.zoom.us:
ZoomMtg.setZoomJSLib('https://source.zoom.us/2.9.5/lib', '/av')
// loads dependent assets
ZoomMtg.preLoadWasm()
ZoomMtg.prepareWebSDK()
// loads language files, also passes any error messages to the ui
ZoomMtg.i18n.load('en-US')
ZoomMtg.i18n.reload('en-US')
