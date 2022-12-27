

        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() }); // convert all text areas to rich text editor on that page

        bkLib.onDomLoaded(function() {
         new nicEditor().panelInstance('area1');
        }); // convert text area with id area1 to rich text editor.

        bkLib.onDomLoaded(function() {
         new nicEditor({fullPanel : true}).panelInstance('area2');
        }); // convert text area with id area2 to rich text editor with full panel.




//<![CDATA[
bkLib.onDomLoaded(function() {
  new nicEditor({maxHeight : 200}).panelInstance('area');
  new nicEditor({fullPanel : true,maxHeight : 200}).panelInstance('area1');
});
  //]]>
