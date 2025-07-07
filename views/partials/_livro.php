<div class="p-2 rounded border-2 border-stone-800 bg-stone-900">
    <div class="flex">
        <div class="w-1/3">
            <img src="<?=$livro->imagem?>" alt="Imagem" class="w-25 rounded">
        </div>
        <div class="flex flex-col gap-1">
            <a href="/livro?id=<?= $livro->id ?>" class="font-semibold hover:underline"><?= $livro->titulo ?></a>
            <div class="text-xs italic"><?= $livro->autor ?></div>
            <div class="text-xs italic"><?= gerarEstrelas($livro->nota_avaliacao, false, true); ?>(<?= $livro->count_avaliacoes ?> Avaliações)</div>
        </div>
    </div>
    <div class="text-sm mt-2">
        <?= $livro->descricao ?>
    </div>
</div>