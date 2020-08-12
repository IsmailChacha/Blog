-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2020 at 10:56 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `Articles`
--

CREATE TABLE `Articles` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Body` text NOT NULL,
  `Image` varchar(255) NOT NULL,
  `String` varchar(255) DEFAULT NULL,
  `Description` varchar(255) NOT NULL,
  `Keywords` varchar(255) NOT NULL,
  `AuthorId` int(11) NOT NULL,
  `Published` tinyint(1) NOT NULL DEFAULT 1,
  `Draft` tinyint(1) NOT NULL DEFAULT 0,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Articles`
--

INSERT INTO `Articles` (`Id`, `Title`, `Body`, `Image`, `String`, `Description`, `Keywords`, `AuthorId`, `Published`, `Draft`, `Date`) VALUES
(3, 'Regular expressions in PHP', 'Regular expressions in PHP', '1596739242_404614.jpg', 'regular-expressions-in-php', 'Regular expressions in PHP', 'Regular expressions in PHP', 1, 0, 1, '2020-08-10'),
(4, 'Regular expressions in Java', '&lt;p&gt;Regular expressions.&lt;/p&gt;', '1596739868_404646.jpg', 'regular-expressions', '', '', 1, 0, 1, '2020-08-07'),
(5, 'Exceptions in PHP', '&lt;p&gt;&lt;strong&gt;(PHP 5, PHP 7)&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;div id=&quot;exception.intro&quot;&gt;\r\n&lt;h3&gt;Introduction&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;div id=&quot;exception.intro&quot;&gt;&lt;strong&gt;Exception&lt;/strong&gt; is the base class for all Exceptions in PHP 5, and the base class for all user exceptions in PHP 7.&lt;/div&gt;\r\n&lt;div&gt;\r\n&lt;h4&gt;Before PHP 7, &lt;strong&gt;Exception&lt;/strong&gt; did not implement the Throwable interface.&lt;/h4&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;/div&gt;\r\n&lt;div id=&quot;exception.synopsis&quot;&gt;\r\n&lt;h3&gt;Class synopsis&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-php&quot;&gt;&lt;code&gt; Exception implements Throwable {\r\n/* Properties */\r\nprotected string $message ;\r\nprotected int $code ;\r\nprotected string $file ;\r\nprotected int $line ;\r\n/* Methods */\r\npublic __construct ([ string $message = &quot;&quot; [, int $code = 0 [, Throwable $previous = NULL ]]] )\r\nfinal public getMessage ( void ) : string\r\nfinal public getPrevious ( void ) : Throwable\r\nfinal public getCode ( void ) : mixed\r\nfinal public getFile ( void ) : string\r\nfinal public getLine ( void ) : int\r\nfinal public getTrace ( void ) : array\r\nfinal public getTraceAsString ( void ) : string\r\npublic __toString ( void ) : string\r\nfinal private __clone ( void ) : void\r\n}&lt;/code&gt;&lt;/pre&gt;\r\n&lt;h3&gt;Properties&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;dl&gt;\r\n&lt;dt id=&quot;exception.props.message&quot;&gt;&lt;var&gt;message&lt;/var&gt;&lt;/dt&gt;\r\n&lt;dd&gt;\r\n&lt;p&gt;The exception message&lt;/p&gt;\r\n&lt;/dd&gt;\r\n&lt;dt id=&quot;exception.props.code&quot;&gt;&lt;var&gt;code&lt;/var&gt;&lt;/dt&gt;\r\n&lt;dd&gt;\r\n&lt;p&gt;The exception code&lt;/p&gt;\r\n&lt;/dd&gt;\r\n&lt;dt id=&quot;exception.props.file&quot;&gt;&lt;var&gt;file&lt;/var&gt;&lt;/dt&gt;\r\n&lt;dd&gt;\r\n&lt;p&gt;The filename where the exception was created&lt;/p&gt;\r\n&lt;/dd&gt;\r\n&lt;dt id=&quot;exception.props.line&quot;&gt;&lt;var&gt;line&lt;/var&gt;&lt;/dt&gt;\r\n&lt;dd&gt;\r\n&lt;p&gt;The line where the exception was created&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;video style=&quot;display: block; margin-left: auto; margin-right: auto;&quot; controls=&quot;controls&quot; width=&quot;300&quot; height=&quot;150&quot;&gt;\r\n&lt;source src=&quot;../../ismail/home/Pictures/1593367608_80s_Disco_Dingo_Simulation_by_Abubakar_NK.jpg&quot; /&gt;&lt;/video&gt;&lt;/p&gt;\r\n&lt;h3&gt;Table of Contents&lt;/h3&gt;\r\n&lt;ul&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::__construct &amp;mdash; Construct the exception&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getMessage &amp;mdash; Gets the Exception message&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getPrevious &amp;mdash; Returns previous Exception&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getCode &amp;mdash; Gets the Exception code&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getFile &amp;mdash; Gets the file in which the exception was created&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getLine &amp;mdash; Gets the line in which the exception was created&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getTrace &amp;mdash; Gets the stack trace&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::getTraceAsString &amp;mdash; Gets the stack trace as a string&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::__toString &amp;mdash; String representation of the exception&lt;/li&gt;\r\n&lt;li style=&quot;text-align: left;&quot;&gt;Exception::__clone &amp;mdash; Clone the exception&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/dd&gt;\r\n&lt;/dl&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;', '1596833272_1593367419_Capucijnengang_by_Artem_Kavalerov.jpg', 'exceptions-in-php', 'The basics of exceptions in the PHP programming language. How to write exception-sensitive code.', 'Exceptions, try catch blocks, exception handling in PHP', 1, 1, 0, '2020-08-10'),
(6, 'How To - Scroll Back To Top Button', '&lt;h2&gt;How To Create a Scroll To Top Button&lt;/h2&gt;\r\n&lt;h5&gt;Step 1) Add HTML:&lt;/h5&gt;\r\n&lt;p&gt;Create a button that will take the user to the top of the page when clicked on:&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-markup&quot;&gt;&lt;code&gt;&amp;lt;button onclick=&quot;topFunction()&quot; id=&quot;myBtn&quot; title=&quot;Go to top&quot;&amp;gt;Top&amp;lt;/button&amp;gt; &lt;/code&gt;&lt;/pre&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h5&gt;Step 2) Add CSS:&lt;/h5&gt;\r\n&lt;p&gt;Style the button:&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-css&quot;&gt;&lt;code&gt;#myBtn {\r\n  display: none; /* Hidden by default */\r\n  position: fixed; /* Fixed/sticky position */\r\n  bottom: 20px; /* Place the button at the bottom of the page */\r\n  right: 30px; /* Place the button 30px from the right */\r\n  z-index: 99; /* Make sure it does not overlap */\r\n  border: none; /* Remove borders */\r\n  outline: none; /* Remove outline */\r\n  background-color: red; /* Set a background color */\r\n  color: white; /* Text color */\r\n  cursor: pointer; /* Add a mouse pointer on hover */\r\n  padding: 15px; /* Some padding */\r\n  border-radius: 10px; /* Rounded corners */\r\n  font-size: 18px; /* Increase font size */\r\n}\r\n\r\n#myBtn:hover {\r\n  background-color: #555; /* Add a dark-grey background on hover */\r\n}&lt;/code&gt;&lt;/pre&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h5&gt;Step 3) Add JavaScript:&lt;/h5&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-javascript&quot;&gt;&lt;code&gt;//Get the button:\r\nmybutton = document.getElementById(&quot;myBtn&quot;);\r\n\r\n// When the user scrolls down 20px from the top of the document, show the button\r\nwindow.onscroll = function() {scrollFunction()};\r\n\r\nfunction scrollFunction() {\r\n  if (document.body.scrollTop &amp;gt; 20 || document.documentElement.scrollTop &amp;gt; 20) {\r\n    mybutton.style.display = &quot;block&quot;;\r\n  } else {\r\n    mybutton.style.display = &quot;none&quot;;\r\n  }\r\n}\r\n\r\n// When the user clicks on the button, scroll to the top of the document\r\nfunction topFunction() {\r\n  document.body.scrollTop = 0; // For Safari\r\n  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera\r\n} &lt;/code&gt;&lt;/pre&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '1597044555_1593367608_80s_Disco_Dingo_Simulation_by_Abubakar_NK.jpg', 'how-to---scroll-back-to-top-button', 'Learn how to create a ', 'Learn how to create a ', 1, 1, 0, '2020-08-10'),
(7, 'Script.js', '&lt;pre class=&quot;language-javascript&quot;&gt;&lt;code&gt;$(document).ready(function () {\r\n  $(\'.menu-toggle\').on(\'click\', function () {\r\n    $(\'.nav\').toggleClass(\'display-nav\');\r\n    $(\'.nav ul\').toggleClass(\'display-nav\');\r\n  });\r\n\r\n// Slick Carousel\r\n  $(\'.post-wrapper\').slick({\r\n    slidesToShow: 3,\r\n    slidesToScroll: 1,\r\n    autoplay: true,\r\n    autoplaySpeed: 2000,\r\n    nextArrow: $(\'.next\'),\r\n    prevArrow: $(\'.prev\'),\r\n    responsive: [\r\n      {\r\n        breakpoint: 1024,\r\n        settings: {\r\n          slidesToShow: 3,\r\n          slidesToScroll: 3,\r\n          infinite: true,\r\n          dots: true\r\n        }\r\n      },\r\n      {\r\n        breakpoint: 600,\r\n        settings: {\r\n          slidesToShow: 2,\r\n          slidesToScroll: 2,\r\n        }\r\n      },\r\n      {\r\n        breakpoint: 480,\r\n        settings: {\r\n          slidesToShow: 1,\r\n          slidesToScroll: 1,\r\n        }\r\n      }\r\n      // You can unslick at a given point by adding \r\n      // settings: &quot;unslick&quot; \r\n      // instead of a settings object\r\n    ]\r\n\r\n  });\r\n});\r\n\r\n  // OPENNING AND CLOSING SIDENAV\r\n  function openSideNav() {\r\n    document.getElementById(&quot;sidenav&quot;).style.width = &quot;90%&quot;;\r\n    document.getElementById(&quot;page-wrapper&quot;).style.opacity = &quot;0.5&quot;;\r\n  }\r\n\r\n  function closeSideNav() {\r\n    document.getElementById(&quot;sidenav&quot;).style.width = &quot;0&quot;;\r\n    document.getElementById(&quot;page-wrapper&quot;).style.opacity = &quot;1&quot;;\r\n  }\r\n\r\n  // SMOOTH SCROLL\r\n  $(document).ready(function(){\r\n    // Add smooth scrolling to all links\r\n    $(&quot;#scroll-arrow&quot;).on(\'click\', function(event) {\r\n  \r\n      // Make sure this.hash has a value before overriding default behavior\r\n      if (this.hash !== &quot;&quot;) {\r\n        // Prevent default anchor click behavior\r\n        event.preventDefault();\r\n  \r\n        // Store hash\r\n        let hash = this.hash;\r\n  \r\n        // Using jQuery\'s animate() method to add smooth page scroll\r\n        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area\r\n        $(\'html, body\').animate({\r\n          scrollTop: $(hash).offset().top\r\n        }, 800, function(){\r\n     \r\n          // Add hash (#) to URL when done scrolling (default click behavior)\r\n          window.location.hash = hash;\r\n        });\r\n      } // End if\r\n    });\r\n  });\r\n\r\n  // GET THE SCROLL BUTTON\r\n  const myScrollButton = document.getElementById(&quot;scroll-arrow&quot;);\r\n  // WHEN THE USER SCROLLS DOWN 20px FROM THE TOP, SHOW THE BUTTON\r\n  window.onscroll = function(){scrollFunction()};\r\n\r\n  function scrollFunction()\r\n  {\r\n    if(document.body.scrollTop &amp;gt; 40 || document.documentElement.scrollTop &amp;gt; 40)\r\n    {\r\n      myScrollButton.style.display = &quot;block&quot;;\r\n    } else \r\n    {\r\n      myScrollButton.style.display = &quot;none&quot;;\r\n    }\r\n  }\r\n\r\n\r\n  myScrollButton.addEventListener(\'click\', topFunction);\r\n\r\n  function topFunction()\r\n  {\r\n    document.scrollTop = 0; //For Safari\r\n    document.documentElement.scrollTop = 0; //For Chrome, IE and Opera\r\n  }\r\n\r\n  // TINYMCE\r\n  tinymce.init({\r\n    selector: \'textarea\',\r\n    menu: \r\n    {\r\n      file: { title: \'File\', items: \'newdocument restoredraft | preview | print \' },\r\n      edit: { title: \'Edit\', items: \'undo redo | cut copy paste | selectall | searchreplace\' },\r\n      view: { title: \'View\', items: \'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen\' },\r\n      insert: { title: \'Insert\', items: \'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime\' },\r\n      format: { title: \'Format\', items: \'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat\' },\r\n      tools: { title: \'Tools\', items: \'spellchecker spellcheckerlanguage | code wordcount\' },\r\n      table: { title: \'Table\', items: \'inserttable | cell row column | tableprops deletetable\' },\r\n      help: { title: \'Help\', items: \'help\' }\r\n    },\r\n    plugins: \'a11ychecker advcode codesample casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker\',\r\n    toolbar: \'a11ycheck addcomment codesample showcomments casechange checklist code formatpainter pageembed permanentpen table\',\r\n    toolbar_mode: \'floating\',\r\n    tinycomments_mode: \'embedded\',\r\n    tinycomments_author: \'Author name\',\r\n  });&lt;/code&gt;&lt;/pre&gt;', '1597050269_1593413892_639111.jpg', 'script.js', 'Script.js', 'Script.js', 1, 1, 0, '2020-08-10'),
(8, 'How TO - Popup Form', '&lt;h2&gt;How To Create a Popup Form&lt;/h2&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h5&gt;Step 1) Add HTML&lt;/h5&gt;\r\n&lt;p&gt;Use a &amp;lt;form&amp;gt; element to process the input. You can learn more about this in our &lt;a href=&quot;https://www.w3schools.com/php/default.asp&quot;&gt;PHP&lt;/a&gt; tutorial.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h3&gt;Example&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-markup&quot;&gt;&lt;code&gt; &amp;lt;div class=&quot;form-popup&quot; id=&quot;myForm&quot;&amp;gt;\r\n  &amp;lt;form action=&quot;/action_page.php&quot; class=&quot;form-container&quot;&amp;gt;\r\n    &amp;lt;h1&amp;gt;Login&amp;lt;/h1&amp;gt;\r\n\r\n    &amp;lt;label for=&quot;email&quot;&amp;gt;&amp;lt;b&amp;gt;Email&amp;lt;/b&amp;gt;&amp;lt;/label&amp;gt;\r\n    &amp;lt;input type=&quot;text&quot; placeholder=&quot;Enter Email&quot; name=&quot;email&quot; required&amp;gt;\r\n\r\n    &amp;lt;label for=&quot;psw&quot;&amp;gt;&amp;lt;b&amp;gt;Password&amp;lt;/b&amp;gt;&amp;lt;/label&amp;gt;\r\n    &amp;lt;input type=&quot;password&quot; placeholder=&quot;Enter Password&quot; name=&quot;psw&quot; required&amp;gt;\r\n\r\n    &amp;lt;button type=&quot;submit&quot; class=&quot;btn&quot;&amp;gt;Login&amp;lt;/button&amp;gt;\r\n    &amp;lt;button type=&quot;submit&quot; class=&quot;btn cancel&quot; onclick=&quot;closeForm()&quot;&amp;gt;Close&amp;lt;/button&amp;gt;\r\n  &amp;lt;/form&amp;gt;\r\n&amp;lt;/div&amp;gt; &lt;/code&gt;&lt;/pre&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h5&gt;Step 2) Add CSS:&lt;/h5&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h3&gt;Example&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-css&quot;&gt;&lt;code&gt; {box-sizing: border-box;}\r\n\r\n/* Button used to open the contact form - fixed at the bottom of the page */\r\n.open-button {\r\n  background-color: #555;\r\n  color: white;\r\n  padding: 16px 20px;\r\n  border: none;\r\n  cursor: pointer;\r\n  opacity: 0.8;\r\n  position: fixed;\r\n  bottom: 23px;\r\n  right: 28px;\r\n  width: 280px;\r\n}\r\n\r\n/* The popup form - hidden by default */\r\n.form-popup {\r\n  display: none;\r\n  position: fixed;\r\n  bottom: 0;\r\n  right: 15px;\r\n  border: 3px solid #f1f1f1;\r\n  z-index: 9;\r\n}\r\n\r\n/* Add styles to the form container */\r\n.form-container {\r\n  max-width: 300px;\r\n  padding: 10px;\r\n  background-color: white;\r\n}\r\n\r\n/* Full-width input fields */\r\n.form-container input[type=text], .form-container input[type=password] {\r\n  width: 100%;\r\n  padding: 15px;\r\n  margin: 5px 0 22px 0;\r\n  border: none;\r\n  background: #f1f1f1;\r\n}\r\n\r\n/* When the inputs get focus, do something */\r\n.form-container input[type=text]:focus, .form-container input[type=password]:focus {\r\n  background-color: #ddd;\r\n  outline: none;\r\n}\r\n\r\n/* Set a style for the submit/login button */\r\n.form-container .btn {\r\n  background-color: #4CAF50;\r\n  color: white;\r\n  padding: 16px 20px;\r\n  border: none;\r\n  cursor: pointer;\r\n  width: 100%;\r\n  margin-bottom:10px;\r\n  opacity: 0.8;\r\n}\r\n\r\n/* Add a red background color to the cancel button */\r\n.form-container .cancel {\r\n  background-color: red;\r\n}\r\n\r\n/* Add some hover effects to buttons */\r\n.form-container .btn:hover, .open-button:hover {\r\n  opacity: 1;\r\n} &lt;/code&gt;&lt;/pre&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h5&gt;Step 3) Add JavaScript:&lt;/h5&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;h3&gt;Example&lt;/h3&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;pre class=&quot;language-javascript&quot;&gt;&lt;code&gt;function openForm() {\r\n  document.getElementById(&quot;myForm&quot;).style.display = &quot;block&quot;;\r\n}\r\n\r\nfunction closeForm() {\r\n  document.getElementById(&quot;myForm&quot;).style.display = &quot;none&quot;;\r\n} &lt;/code&gt;&lt;/pre&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '1597098840_1593466538_images (4).jpeg', 'how-to---popup-form', 'Learn how to create a popup form with CSS and JavaScript.', 'Learn how to create a popup form with CSS and JavaScript.', 1, 1, 0, '2020-08-11');

-- --------------------------------------------------------

--
-- Table structure for table `ArticleTopics`
--

CREATE TABLE `ArticleTopics` (
  `ArticleId` int(11) NOT NULL,
  `TopicId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ArticleTopics`
--

INSERT INTO `ArticleTopics` (`ArticleId`, `TopicId`) VALUES
(0, 1),
(0, 2),
(0, 3),
(0, 4),
(0, 8),
(0, 10),
(0, 13),
(0, 15),
(0, 16),
(0, 17),
(1, 1),
(1, 2),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 8),
(3, 10),
(3, 13),
(3, 15),
(3, 16),
(3, 17),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 8),
(5, 10),
(5, 13),
(5, 15),
(5, 16),
(5, 17),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 8),
(6, 10),
(6, 13),
(6, 15),
(6, 16),
(6, 17),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 8),
(7, 10),
(7, 13),
(7, 15),
(7, 16),
(7, 17),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 8),
(8, 10),
(8, 13),
(8, 15),
(8, 16),
(8, 17);

-- --------------------------------------------------------

--
-- Table structure for table `Mailing_List`
--

CREATE TABLE `Mailing_List` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Mailing_List`
--

INSERT INTO `Mailing_List` (`Id`, `Name`, `Email`) VALUES
(1, 'Ismail', 'ismail.mxxiv@yahoo.com'),
(2, 'Ismail Chacha', 'ismail.mxxiv@gmail.com'),
(3, 'Habiba Boke', 'habibaboke@yahoo.com'),
(4, 'Einstein', 'ismail.mxxiv@ismail.com'),
(5, 'Einstein', 'customer.yahoo@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `Topics`
--

CREATE TABLE `Topics` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Topics`
--

INSERT INTO `Topics` (`Id`, `Name`, `Description`) VALUES
(1, 'PHP', 'PHP'),
(2, 'JAVA', '<p>Java</p>'),
(3, 'PYTHON', 'Python'),
(4, 'RUBY', 'Ruby'),
(10, 'IOT', 'IOT'),
(13, 'LINUX', 'LINUX'),
(16, 'CLOUD', 'Cloud'),
(17, 'JAVASCRIPT', '<p>Javascript</p>');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Superuser` tinyint(1) NOT NULL DEFAULT 0,
  `Admin` tinyint(1) NOT NULL DEFAULT 0,
  `Password` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`Id`, `FirstName`, `LastName`, `Email`, `Superuser`, `Admin`, `Password`, `Date`) VALUES
(1, 'Ismail', 'Chacha', 'ismail.mxxiv@yahoo.com', 1, 1, '$2y$10$q3.db9agMidB24gw4TIUQecUieAc2p/L0qtPq7JsIc4VpR6WBO6MO', '2020-08-06'),
(2, 'Habiba', 'Boke', 'habibaboke@yahoo.com', 0, 0, '$2y$10$zBqGbnkeDPHt/hgq8EUG8ODLDjhOAJ7Nn.4Kd4ZEuSmaRORBqJT/C', '2020-08-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `authorid` (`AuthorId`),
  ADD KEY `Identifier String` (`String`);

--
-- Indexes for table `ArticleTopics`
--
ALTER TABLE `ArticleTopics`
  ADD PRIMARY KEY (`ArticleId`,`TopicId`);

--
-- Indexes for table `Mailing_List`
--
ALTER TABLE `Mailing_List`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Topics`
--
ALTER TABLE `Topics`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Articles`
--
ALTER TABLE `Articles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Mailing_List`
--
ALTER TABLE `Mailing_List`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Topics`
--
ALTER TABLE `Topics`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
