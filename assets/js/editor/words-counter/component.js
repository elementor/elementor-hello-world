import * as hooks from './hooks/ui/index.js';

export default class Component extends $e.modules.ComponentBase {
  getNamespace() {
    return 'words-counter';
  }

  defaultHooks() {
    return this.importHooks( hooks );
  }

  countWords() {
    // Clone current document elements.
    const html = elementor.documents.getCurrent().$element.clone();

    // Remove the element edit tools elements.
    html.find( '.elementor-editor-element-settings, .elementor-column-percents-tooltip' ).remove();

    const words = html.text().match( /\S+/g );

    this.getBadge().html( `Words: ${ words.length }` );

    /* TODO: add a throttling wrapper in order to avoid extra parsing if
     there is a lot of changes at once. (e.g on import a template and
     on undo many steps)
     */
  }

  getBadge() {
    const badgeClassName = 'elementor-editor-words-counter';

    let $badge = elementorCommon.elements.$body.find( `.${ badgeClassName }` );

    if ( ! $badge.length ) {
      $badge = jQuery( '<div />', {
        class: badgeClassName,
        style: 'position:fixed;bottom:0;right:0;padding:10px;background:yellow;color: black;'
      } );

      elementorCommon.elements.$body.append( $badge );
    }

    return $badge;
  }
}
