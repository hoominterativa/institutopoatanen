$(".box").each(function() {
    // Encontre elementos de guia e conteúdo dentro da caixa atual
    let $box = $(this);
    let $tabs = $box.find(".tab");
    let $tabContents = $box.find(".tab-content");

    $tabs.on('click', function(event) {
        event.preventDefault(); // Impede o comportamento padrão de rolagem

        let tabClass = $(this).data("tab");

        // Esconder todo o conteúdo da aba na caixa atual
        $tabContents.removeClass("active-tab");

        // Exibir apenas o conteúdo da aba selecionada na caixa atual
        $box.find("." + tabClass).addClass("active-tab");

        // Remover a classe 'active' de todas as abas na caixa atual
        $tabs.removeClass("active");

        // Adicionar a classe 'active' à aba selecionada na caixa atual
        $(this).addClass("active");
    });

    // Ativar a primeira aba por padrão na caixa atual
    $tabs.first().trigger("click");
});
