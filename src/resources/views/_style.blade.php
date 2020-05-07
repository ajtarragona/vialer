

.vialer-field .form-group{
    border-width: 0px;
    margin-bottom: 0;
    border-bottom-width: 1px;
}

.vialer-field .form-group label{
    white-space:nowrap;
    text-overflow:ellipsis;
    overflow: hidden;
}

.vialer-field .form-group.focused{
    box-shadow:none;
    background: transparent;
}

.vialer-field .viaform .inputVia{
}


table.sticky-header thead th{
    position: sticky;
    top: 0px;
    background-color:white;
    /* border-bottom:1px solid #ccc */
    /* box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4); */
}

table.sticky-header tbody tr{
    cursor:pointer;
}
.vialer-field .vialer-map{
    min-height:300px;
}

.vialer-field.map-left .vialer-map,
.vialer-field.map-right .vialer-map{
    height:100%;
}

.vialer-field.map-left .vialer-map{
    border-right: 1px solid rgba(52,58,64,.13);
}
.vialer-field.map-right .vialer-map{
    border-left: 1px solid rgba(52,58,64,.13);
}
.vialer-field.map-top .vialer-map{
    border-bottom: 1px solid rgba(52,58,64,.13);
}
.vialer-field.map-bottom .vialer-map{
    border-top: 1px solid rgba(52,58,64,.13);
}

.card.with-bg .card-header-tabs .nav-link:not(.active){
    color: white;
}

.vialer-field .card-header{
    position:relative
}
.vialer-field .card-header .clean-btn{
    position:absolute;
    right:0;
    top:0;
    padding:6px
}

.vialer-field.map-left .tab-content,
.vialer-field.map-right .tab-content{
    height: calc(100% - 51px);
}

.vialer-search-form .form-group label{
    white-space:nowrap;
    text-overflow:ellipsis;
    overflow: hidden;
    padding-left:0 !important;
}
.vialer-search-form .form-group .form-control{
    padding-left:0 !important;
}
.vialer-search-form .form-group .form-control:not(.nom_carrer){
    width: 50px;
}

.vialer-search-form .form-group.focused{
    box-shadow:none;
    background: transparent;
}
