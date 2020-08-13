tinymce.init({
	selector: 'textarea',
	menu: 
	{
		file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
		edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
		view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
		insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
		format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
		tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
		table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
		help: { title: 'Help', items: 'help' }
	},

	plugins: 'a11ychecker advcode codesample casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen table advtable tinycomments tinymcespellchecker advlist link image charmap print preview anchor searchreplace visualblocks fullscreen insertdatetime media table',
	toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample code showcomments casechange checklist  formatpainter',
	toolbar_mode: 'floating',
	tinycomments_mode: 'embedded',
	tinycomments_author: 'Author name',
});