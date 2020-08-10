<?php
namespace Ninja
{
	class Markdown
	{
		private $string;

		public function __construct($markDown)
		{
			$this->string = $markDown;
		}

		public function toHTML()
		{
			// convert $this->string to html
			$text = htmlspecialchars($this->string, ENT_QUOTES, 'UTF-8');

			// strong(bold)
			$text = preg_replace('/__([.+?])__/s', '<strong>$1</strong>', $text); //Double emphasis first
			$text = preg_replace('/\*\*([.+?])\*\*/s', '<strong>$n</strong>', $text); //Normal emphasis

			// emphasis(italic)
			$text = preg_replace('/_([^_]+)_/', '<em>$1</em>',$text);
			$text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);

			// newlines
			// convert Windows (\r\n) to Unix's (\n)
			// $text = preg_replace('/\r\n/', "\n", $text);
			// // Convert Macintosh's (\r) to Unix's (\n)
			// $text = preg_replace('/\r/', "\n", $text);

			// convert Windows (\r\n) to Unix's (\n)
			$text = str_replace("\r\n", "\n", $text);
			// Convert Macintosh's (\r) to Unix's (\n)
			$text = str_replace("\r", "\n", $text);

			// paragraphs
			// $text = '<p>' . preg_replace('/\n\n/', '</p><p>', $text) . '</p>';
			// line breaks
			// $text = preg_replace('/\n/'. '<br>', $text);

			// paragraphs
			$text = '<p>' . str_replace("\n\n", "</p><p>", $text). '</p>';
			// line breaks
			$text = str_replace("n", '<br>', $text);

			// Hyperlinks [linked text](link URL)
			$text = str_replace('/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%])+)\)/i', '<a href="$2">$1</a>', $text);

			return $text;
		}
	}
}