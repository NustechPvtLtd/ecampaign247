$(function() {
    var site_url = $('#site-url').data("content");
    $("#visitor_grid1").bs_grid({
        pageNum: 1,
        rowsPerPage: 10,
        maxRowsPerPage: 100,
        ajaxFetchDataURL: site_url+"/visitor/getVisitor",
        row_primary_key: "id",
        columns: [
            {field: "id", header: "ID", visible: "no", "sortable": "no"},
            {field: "page_url", header: "Page Url"},
            {field: "total_hit", header: "Total Hit"},
            {field: "unique_hit", header: "Unique Hit"},
        ],
        useFilters: false,
        showRowNumbers: true,
        showSortingIndicator: false,
        useSortableLists: false,
        customHTMLelementID1: "",
        customHTMLelementID2: "",

        /* STYLES ----------------------------------------------------*/
        bootstrap_version: "3",

        // bs 3
        containerClass: "grid_container",
        noResultsClass: "alert alert-warning no-records-found",

        toolsClass: "tools",

        columnsListLaunchButtonClass: "btn btn-default dropdown-toggle",
        columnsListLaunchButtonIconClass: "glyphicon glyphicon-th",
        columnsListClass: "dropdown-menu dropdown-menu-right",
        columnsListLabelClass: "columns-label",
        columnsListCheckClass: "col-checkbox",
        columnsListDividerClass: "divider",
        columnsListDefaultButtonClass: "btn btn-primary btn-xs btn-block",

        sortingListLaunchButtonIconClass: "glyphicon glyphicon-sort",
        sortingLabelCheckboxClass: "radio-inline",
        sortingNameClass: "sorting-name",

        selectButtonIconClass: "glyphicon  glyphicon-check",
        selectedRowsClass: "selected-rows",

        filterToggleButtonIconClass: "glyphicon glyphicon-filter",
        filterToggleActiveClass: "btn-info",

        sortingIndicatorAscClass: "glyphicon glyphicon-chevron-up text-muted",
        sortingIndicatorDescClass: "glyphicon glyphicon-chevron-down text-muted",

        dataTableContainerClass: "table-responsive",
        dataTableClass: "table table-bordered table-hover",
        commonThClass: "th-common",
        selectedTrClass: "warning",

        filterContainerClass: "well filters-container",
        filterToolsClass: "",
        filterApplyBtnClass: "btn btn-primary btn-sm filters-button",
        filterResetBtnClass: "btn btn-default btn-sm filters-button",

        // prefixes
        tools_id_prefix: "tools_",
        columns_list_id_prefix: "columns_list_",
        sorting_list_id_prefix: "sorting_list_",
        sorting_radio_name_prefix: "sort_radio_",
        selected_rows_id_prefix: "selected_rows_",
        selection_list_id_prefix: "selection_list_",
        filter_toggle_id_prefix: "filter_toggle_",

        table_container_id_prefix: "tbl_container_",
        table_id_prefix: "tbl_",

        no_results_id_prefix: "no_res_",

        custom_html1_id_prefix: "custom1_",
        custom_html2_id_prefix: "custom2_",

        pagination_id_prefix: "pag_",
        filter_container_id_prefix: "flt_container_",
        filter_rules_id_prefix: "flt_rules_",
        filter_tools_id_prefix: "flt_tools_",

        // misc
        debug_mode: "no",
    });
 
});