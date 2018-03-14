// Redirect div->article
$('.article').on('click', function () {
    var link = $(this).find('a').attr('href')
    console.log(link);
    window.location.assign(link)
});