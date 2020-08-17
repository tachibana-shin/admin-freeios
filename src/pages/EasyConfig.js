import EasyMDE from "easymde"
export default {
   spellChecker: false,
   autosave: {
      enabled: false
   },
   autoDownloadFontAwesome: false,
   forceSync: true,
   //autofocus: true,
   //promptURLs: false,
   toolbar: [
      { name: "bold", action: EasyMDE.toggleBold, className: "fa fa-bold", title: "Bold" },
      { name: "italic", action: EasyMDE.toggleStrikethrough, className: "fa fa-strikethrough", title: "Strikethrough" },
      { name: "strikethrough", action: EasyMDE.toggleItalic, className: "fa fa-italic", title: "Italic" },
      { name: "heading-1", action: EasyMDE.toggleHeadingBigger, className: "fa fa-header fa-header-x", title: "Bold" },
      { name: "heading-1", action: EasyMDE.toggleHeading1, className: "fa fa-header fa-header-x fa-header-1", title: "Bold" },
      { name: "heading-2", action: EasyMDE.toggleHeading2, className: "fa fa-header fa-header-x fa-header-2", title: "Bold" },
      { name: "heading-3", action: EasyMDE.toggleHeading3, className: "fa fa-header fa-header-x fa-header-3", title: "Bold" },
                       "|",
      { name: "code", action: EasyMDE.toggleCodeBlock, className: "fa fa-code", title: "Code" },
      { name: "quote", action: EasyMDE.toggleBlockquote, className: "fa fa-quote-left", title: "Quote" },
      { name: "unordered-list", action: EasyMDE.toggleUnorderedList, className: "fa fa-list-ul", title: "Generic List" },
      { name: "ordered-list", action: EasyMDE.toggleOrderedList, className: "fa fa-list-ol", title: "Numbered List" },
      { name: "table", action: EasyMDE.drawTable, className: "fa fa-table", title: "Insert Table" },
      { name: "horizontal-rule", action: EasyMDE.drawHorizontalRule, className: "fa fa-minus", title: "Insert Horizontal Line" },
      { name: "clean-block", action: EasyMDE.cleanBlock, className: "fa fa-eraser fa-clean-block", title: "Clean block" },
   "|",
      { name: "bold", action: EasyMDE.drawLink, className: "fa fa-link", title: "Create Link" },
                       "|",
      { name: "preview", action: EasyMDE.togglePreview, className: "fa fa-eye no-disable", title: "Toggle Preview" },
      { name: "side-by-side", action: EasyMDE.toggleSideBySide, className: "fa fa-columns no-disable no-mobile", title: "Toggle Side by Side" },
      { name: "fullscreen", action: EasyMDE.toggleFullScreen, className: "fa fa-arrows-alt no-disable no-mobile", title: "Toggle Fullscreen" },
                       "|",
      { name: "undo", action: EasyMDE.togglePreview, className: "fa fa-undo no-disable", title: "Undo" },
      { name: "redo", action: EasyMDE.togglePreview, className: "fa fa-repeat no-disable", title: "Redo" }
          ]
}