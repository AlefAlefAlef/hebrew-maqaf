(function(){
	tinymce.create('tinymce.plugins.maqaf_plugin', {
		init: function(ed, url){
			ed.addButton('aaa_hebrew_maqaf', {
				title: AAAHT.maqaf.add_button_text,
				cmd: 'aaa_addMakafCmd',
				image: url + '/img/maqaf-icon.svg'
			});
			
			ed.addCommand('aaa_addMakafCmd', function(){
				var HEBREW_MAQAF = AAAHT.maqaf.character;
				var selectedText = ed.selection.getContent({format: 'html'});
				if (selectedText.length && ['-', ' ', '־'].indexOf(selectedText) < 0) {
					var newText = selectedText;
					
					// Go over blacklist
					var blacklist = AAAHT.maqaf.blacklist;
					for (let i = 0; i < blacklist.length; i++) {
						const element = blacklist[i].split('_');
						newText = newText.replace(RegExp(element[0] + "(-| )"+element[1], 'g'), element[0] + HEBREW_MAQAF + element[1]);
					}
					
					newText = newText.replace(/([א-ת])-([A-z0-9]+)/g, "$1" + HEBREW_MAQAF + "$2");
					ed.execCommand('mceInsertContent', 0, newText);
				} else {
					ed.execCommand('mceInsertContent', 0, HEBREW_MAQAF);
				}
			});
			
		},
		getInfo: function() {
			return {
				longname : 'AlefAlefAlef Maqaf Plugin',
				author : 'Reuven Karasik',
				version : '1.0'
			};
		}
	});
	tinymce.PluginManager.add( 'maqaf_plugin', tinymce.plugins.maqaf_plugin );
})();