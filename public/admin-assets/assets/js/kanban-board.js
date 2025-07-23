$(function () {
    // Draggble Item
    function kanbanSortable() {
        $('[data-sortable="true"]').sortable({
            connectWith: ".connect-sorting-content",
            items: ".card",
            cursor: "move",
            placeholder: "ui-state-highlight",
            refreshPosition: true,
            stop: function (event, ui) {
                var parent_ui = ui.item.parent().attr("data-item");
            },
            update: function (event, ui) {
                console.log(ui);
                console.log(ui.item);
            },
        });
    }

    // clear all task on click
    function clearItem() {
        $(".list-clear-all")
        .off("click")
        .on("click", function (event) {
            event.preventDefault();
            $(this)
            .parents('[data-action="sorting"]')
            .find(".connect-sorting-content .card")
            .remove();
        });
    }

    // add task and open modal
    function addKanbanItem() {
        $(".addTask").on("click", function (event) {
            event.preventDefault();
            getParentElement = $(this)
                .parents('[data-action="sorting"]')
                .attr("data-item");
            $(".edit-task-title").hide();
            $(".add-task-title").show();
            $('[data-btn-action="addTask"]').show();
            $('[data-btn-action="editTask"]').hide();
            // $('.addTaskAccordion .collapse').collapse('hide');
            $("#addItemModal").modal("show");
            kanban_add(getParentElement);
        });
    }

    // add default item
    function kanban_add(getParent) {
        $('[data-btn-action="addTask"]')
        .off("click")
        .on("click", function (event) {
            getAddBtnClass = $(this).attr("class").split(" ")[1];

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth());

            var monthNames = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
            ];

            today = dd + " " + monthNames[mm];

            var $_getParent = getParent;

            var itemTitle = document.getElementById("kanban-title").value;
            var itemText = document.getElementById("kanban-text").value;

            item_html =
            '<div data-draggable="true" class="card border-0 rounded-3 img-task mb-25 d-inline-block w-100" style="">' +
            '<div class="card-body p-20">' +
            '<div class="task-header d-flex justify-content-between align-items-center mb-3">' +
            '<div class="">' +
            '<h4 class="fs-16 fw-semibold mb-0" data-item-title="' +
            itemTitle +
            '">' +
            itemTitle +
            "</h4>" +
            "</div>" +
            '<div class="">' +
            '<div class="dropdown action-dropdown">' +
            '<a class="btn border-0 read-more-dot p-0 w-auto h-auto bg-white lh-1" href="#" role="button" id="dropdownMenuLink-4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">' +
            '<i class="ri-icon ri-more-fill"></i>' +
            "</a>" +
            '<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-4">' +
            '<a class="dropdown-item fs-14 text-body kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"><i class="ri-edit-box-line text-primary"></i> Edit</a>' +
            '<a class="dropdown-item fs-14 text-body kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);"><i class="ri-delete-bin-7-line text-primary"></i> Delete</a>' +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="task-body">' +
            '<div class="task-content">' +
            '<p class="mb-0 text-body" data-item-text="' +
            itemText +
            '">' +
            itemText +
            "</p>" +
            "</div>" +
            '<div class="task-bottom d-flex justify-content-between align-items-center mt-3">' +
            '<div class="tb-section-1">' +
            '<span class="hstack gap-2 fs-15 fw-medium" data-item-date="' +
            today +
            '"><i class="ri-calendar-line text-primary"></i> ' +
            today +
            "</span>" +
            "</div>" +
            '<div class="tb-section-2">' +
            '<span class="badge bg-success fw-normal fs-14 text-white">Design</span>' +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

            $("[data-item='" + $_getParent + "'] .connect-sorting-content").append(
            item_html
            );

            $("#addItemModal").modal("hide");

            kanbanEdit();
            kanbanDelete();
        });
    }

    // add item
    $("#add-list")
        .off("click")
        .on("click", function (event) {
        event.preventDefault();

        $(".add-list").show();
        $(".edit-list").hide();
        $(".edit-list-title").hide();
        $(".add-list-title").show();
        $("#addListModal").modal("show");
    });

    // Sdd list
    $(".add-list")
    .off("click")
    .on("click", function (event) {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");
        var mm = String(today.getMonth() + 1).padStart(2, "0");

        today = mm + "." + dd;

        var itemTitle = document.getElementById("item-name").value;

        var itemNameLowercase = itemTitle.toLowerCase();
        var itemNameRemoveWhiteSpace = itemNameLowercase.split(" ").join("_");
        var itemDataAttr = itemNameRemoveWhiteSpace;

        item_html =
            '<div data-item="item-' +
            itemDataAttr +
            '" class="task-list-container  mb-4 " data-action="sorting">' +
            '<div class="connect-sorting bg-primary-transparent">' +
            '<div class="task-container-header d-flex align-items-center justify-content-between pb-25">' +
            '<h4 class="item-head mb-0 fw-semibold" data-item-title="' +
            itemTitle +
            '">' +
            itemTitle +
            "</h4>" +
            '<div class="hstack gap-2">' +
            '<div class="dropdown action-dropdown">' +
            '<a class="btn border-0 read-more-dot p-0 bg-white" href="#" role="button" id="dropdownMenuLink-4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">' +
            '<i class="ri-icon ri-more-2-fill text-body"></i>' +
            "</a>" +
            '<div class="dropdown-menu dropdown-menu-end border-color" aria-labelledby="dropdownMenuLink-4">' +
            '<a class="dropdown-item fs-14 text-body list-edit" href="javascript:void(0);"><i class="ri-edit-box-line text-primary"></i> Edit</a>' +
            '<a class="dropdown-item fs-14 text-body list-delete" href="javascript:void(0);"><i class="ri-delete-bin-7-line text-primary"></i> Delete</a>' +
            '<a class="dropdown-item fs-14 text-body list-clear-all" href="javascript:void(0);"><i class="ri-close-circle-line text-primary"></i> Clear All</a>' +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="connect-sorting-content" data-sortable="true">' +
            "</div>" +
            "</div>" +
            "</div>";

        $(".task-list-section").append(item_html);
        $("#addListModal").modal("hide");
        $("#item-name").val("");
        kanbanSortable();
        editItem();
        deleteItem();
        clearItem();
        addKanbanItem();
        kanbanEdit();
        kanbanDelete();

        // Tooltip
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

  
    // edit item
    function editItem() {
        $(".list-edit")
        .off("click")
        .on("click", function (event) {
            event.preventDefault();

            var parentItem = $(this);

            $(".add-list").hide();
            $(".edit-list").show();

            $(".add-list-title").hide();
            $(".edit-list-title").show();

            var itemTitle = parentItem
            .parents('[data-action="sorting"]')
            .find(".item-head")
            .attr("data-item-title");
            $("#item-name").val(itemTitle);

            $(".edit-list")
            .off("click")
            .on("click", function (event) {
                var $_innerThis = $(this);
                var $_getListTitle = document.getElementById("item-name").value;

                var $_editedListTitle = parentItem
                .parents('[data-action="sorting"]')
                .find(".item-head")
                .html($_getListTitle);
                var $_editedListTitleDataAttr = parentItem
                .parents('[data-action="sorting"]')
                .find(".item-head")
                .attr("data-item-title", $_getListTitle);

                $("#addListModal").modal("hide");
                $("#item-name").val("");
            });
            $("#addListModal").modal("show");
            $("#addListModal").on("hidden.bs.modal", function (e) {
                $("#item-name").val("");
            });
        });
    }

    // All list delete
    function deleteItem() {
        $(".list-delete")
        .off("click")
        .on("click", function (event) {
            event.preventDefault();
            $(this).parents("[data-action]").remove();
        });
    }


    // Delete item on click
    function kanbanDelete() {
        $(".card .kanban-item-delete")
        .off("click")
        .on("click", function (event) {
            event.preventDefault();

            get_card_parent = $(this).parents(".card");

            $("#deleteConformation").modal("show");

            $('[data-remove="task"]').on("click", function (event) {
            event.preventDefault();
            /* Act on the event */
            get_card_parent.remove();
            $("#deleteConformation").modal("hide");
            });
        });
    }

    // Edit item on click
    function kanbanEdit() {
        $(".card .kanban-item-edit")
        .off("click")
        .on("click", function (event) {
            event.preventDefault();

            var parentItem = $(this);

            $(".add-task-title").hide();
            $(".edit-task-title").show();

            $('[data-btn-action="addTask"]').hide();
            $('[data-btn-action="editTask"]').show();

            var itemKanbanTitle = parentItem
            .parents(".card")
            .find("h4")
            .attr("data-item-title");
            var get_kanban_title = $(".task-text-progress #kanban-title").val(
            itemKanbanTitle
            );

            var itemText = parentItem
            .parents(".card")
            .find('p:not(".progress-count")')
            .attr("data-item-text");
            var get_kanban_text = $(".task-text-progress #kanban-text").val(
            itemText
            );

            $('[data-btn-action="editTask"]')
            .off("click")
            .on("click", function (event) {
                var kanbanValueTitle =
                document.getElementById("kanban-title").value;
                var kanbanValueText = document.getElementById("kanban-text").value;

                var itemDataAttr = parentItem
                .parents(".card")
                .find("h4")
                .attr("data-item-title", kanbanValueTitle);
                var itemKanbanTitle = parentItem
                .parents(".card")
                .find("h4")
                .html(kanbanValueTitle);
                var itemTextDataAttr = parentItem
                .parents(".card")
                .find('p:not(".progress-count")')
                .attr("data-tasktext", kanbanValueText);
                var itemText = parentItem
                .parents(".card")
                .find('p:not(".progress-count")')
                .html(kanbanValueText);

                $("#addItemModal").modal("hide");
                var setDate = $(".taskDate").html("");
                $(".taskDate").hide();
            });
            $("#addItemModal").modal("show");
        });
    }

    editItem();
    deleteItem();
    clearItem();
    addKanbanItem();
    kanbanEdit();
    kanbanDelete();
    kanbanSortable();
});