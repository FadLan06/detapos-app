<style type="text/css">
    .onoffswitch { 
        position: relative; 
        width: 95px;
        -webkit-user-select:none; 
        -moz-user-select:none; 
        -ms-user-select: none; 
    } .onoffswitch-checkbox { 
        display: none; 
    } .onoffswitch-label { 
        display: block; 
        overflow: hidden; 
        cursor: pointer; 
        /*border: 2px solid #999999; */
        border-radius: 0px; 
    } .onoffswitch-inner { 
        display: block; 
        width: 200%; 
        margin-left: -100%; 
        transition: margin 0.3s ease-in 0s; 
    } .onoffswitch-inner:before, .onoffswitch-inner:after { 
        display: block; 
        float: left; 
        width: 50%; 
        height: 30px; 
        padding: 0; 
        line-height: 26px; 
        font-size: 14px; 
        color: white; 
        font-family: Trebuchet, Arial, sans-serif; 
        font-weight: bold; 
        box-sizing: border-box; 
        border: 2px solid transparent; 
        background-clip: padding-box; 
    } .onoffswitch-inner:before { 
        content: " Ya"; 
        padding-left: 10px; 
        background-color: #327D1F; 
        color: #FFFFFF;
        border-radius: 34px; 
    } .onoffswitch-inner:after { 
        content: "Tidak"; 
        padding-right: 10px; 
        background-color: #CF1414; 
        color: #FFFFFF; text-align: right;
        border-radius: 34px; 
    } .onoffswitch-switch { 
        display: block; 
        width: 18px; 
        margin: 0px; 
        background: #ccc; 
        position: absolute; 
        top: 0; 
        bottom: 0; 
        right: 77px; 
        transition: all 0.3s ease-in 0s; 
        border-radius: 34px; 
    } .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner { 
        margin-left: 0; 
    } .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch { 
        right: 0px; 
    } 
</style>