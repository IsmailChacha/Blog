const div = document.getElementById('msg');
if(div !== null)
{
    document.getElementById('msg').style.display == 'none'
    window.setTimeout((div) => {
    $('#msg').fadeOut(1500);
    }, 8000);
}  
