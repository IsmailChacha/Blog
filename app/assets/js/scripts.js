  // WARN WHEN INPUT FIELD MAXLENGTH EXCEEDED
  const field = document.getElementById('title');
  field.addEventListener('keyup', exceeded);

  function exceeded()
  {
    const statusMessage = document.getElementById('statusMessage');
    if(field.value.length >= 70)
    {
      statusMessage.innerHTML = 'You\'ve reached the maximum length for this field';
    } else 
    {
      if(field.value.length >= 50)
      {
        statusMessage.innerHTML = 'You have ' + (70 - field.value.length) + ' characters remaining';
      }
    }
  }

  // ASK FOR CONFIRMATION TO DELETE ARTICLE
  function deleteArticle(Title, String)
  {
    if(confirm("Are you sure to delete the article '" + Title + "'?"))
    {
      window.location.href = '/private/index.php/delete/article/' + String;
    }
  }

  // ASK FOR CONFIRMATION TO DELETE TOPIC
  function deleteTopic(Name, Id)
  {
    if(confirm("Are you sure to delete the topic '" + Name + "'?"))
    {
      window.location.href = '/private/index.php/deletetopic/topic/' + Id;
    }
  }
  