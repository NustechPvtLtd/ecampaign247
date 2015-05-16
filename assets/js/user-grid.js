$(function() {
    var site_url = $('#site-url').data("content");
    $("#user_grid1").bs_grid({
        pageNum: 1,
        rowsPerPage: 10,
        maxRowsPerPage: 100,
        ajaxFetchDataURL: site_url+"/user/getUserData",
        row_primary_key: "id",

        columns: [
            {field: "id", header: "ID", visible: "no", "sortable": "no"},
            {field: "username", header: "Username"},
            {field: "first_name", header: "First Name"},
            {field: "last_name", header: "Last Name"},
            {field: "email", header: "Email", visible: "no", "sortable": "no"},
            {field: "phone", header: "Phone", visible: "no", "sortable": "no"},
            {field: "status", header: "Status"},
            {field: "company", header: "Company"},
            {field: "role_name", header: "Role"},
            {field: "parent", header: "Parent", visible: "no"},
            {field: "last_login", header: "Last Login", visible: "no"},
            {field: "created_on", header: "Created On", visible: "no"}
        ],
 
        sorting: [
            {sortingName: "Username", field: "username", order: "ascending"},
            {sortingName: "First Name", field: "first_name", order: "ascending"},
            {sortingName: "Created On", field: "created_on", order: "none"}
        ],
 
        filterOptions: {
            filters: [
                {
                    filterName: "Username", "filterType": "text", field: "username", filterLabel: "Username",
                    excluded_operators: ["in", "not_in"],
                    filter_interface: [
                        {
                            filter_element: "input",
                            filter_element_attributes: {"type": "text"}
                        }
                    ]
                },
                {
                    filterName: "Status", "filterType": "number", "numberType": "integer", field: "lk_status_id", filterLabel: "Status",
                    excluded_operators: ["equal", "not_equal", "less", "less_or_equal", "greater", "greater_or_equal"],
                    filter_interface: [
                        {
                            filter_element: "input",
                            filter_element_attributes: {type: "checkbox"}
                        }
                    ],
                    lookup_values: [
                        {lk_option: "Active", lk_value: "1", lk_selected: "yes"},
                        {lk_option: "In-active", lk_value: "0"}
                    ]
                },
                {
                    filterName: "CreatedOn", "filterType": "date", field: "created_on", filterLabel: "Created On",
                    excluded_operators: ["in", "not_in"],
                    filter_interface: [
                        {
                            filter_element: "input",
                            filter_element_attributes: {
                                type: "text",
                                title: "Set the date and time using format: dd/mm/yyyy hh:mm:ss"
                            },
                            filter_widget: "datetimepicker",
                            filter_widget_properties: {
                                dateFormat: "dd/mm/yy",
                                timeFormat: "HH:mm:ss",
                                changeMonth: true,
                                changeYear: true,
                                showSecond: true
                            }
                        }
                    ],
                    validate_dateformat: ["DD/MM/YYYY HH:mm:ss"],
                    filter_value_conversion: {
                        function_name: "local_datetime_to_UTC_timestamp",
                        args: [
                            {"filter_value": "yes"},
                            {"value": "DD/MM/YYYY HH:mm:ss"}
                        ]
                    }
                }
            ],
            filter_rules: [
                {
                    "condition": {
                        "filterType": "text",
                        "field": "username",
                        "operator": "contains",
                        "filterValue": [
                            "A"
                        ]
                    },
                    "logical_operator": "AND"
                },
                {
                    "condition": {
                        "filterType": "number",
                        "numberType": "integer",
                        "field": "lk_status_id",
                        "operator": "in",
                        "filterValue": [
                            "1"
                        ]
                    },
                    "logical_operator": "AND"
                }
            ]
        },
        useFilters: false,
        showRowNumbers: false,
        showSortingIndicator: true,
        useSortableLists: true,
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