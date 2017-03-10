$(function()
{
  var table = $(".default-datatable").dataTable(
  {
    sPaginationType: "bootstrap",
    aLengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todas"]],
    bStateSave: true,
    oLanguage: {
      sSearch: 'Pesquisar:',
      sLengthMenu: '_MENU_ linhas por página',
      sLoadingRecords: 'Carregando..',
      sProcessing: 'Processando..',
      sInfoEmpty: 'Ops.. Parece que não há nenhum dado para mostrar!',
      sInfoFiltered: '',
      sZeroRecords: 'Nenhum item encontrado',
      sInfo: 'No total são _TOTAL_ items e estamos mostrando do _START_ até _END_'
    }
  });

  table.columnFilter(
  {
    sPlaceHolder : "head:after"
  });
});