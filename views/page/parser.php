<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Парсер html</title>
        
        <style>
            
            body{
                font-family: Arial, sans-serif;
            }
            
            
            .content-wrapper{
                display:flex; 
                flex-direction: row;
                justify-content:center;
            }
            
            .content{
                width:600px;
            }
            
            
            .l1{
                display: inline-block;
                margin-bottom: 10px;
            }
            
            .error{
                font-size: 12px;
                color:#f00;
            }
            
            .result-table{
                text-align: center;
                border:solid 1px #555; 
                border-collapse: collapse;
            }
            
            .result-table td, .result-table th{
                border:solid 1px #555;
                padding: 5px 10px;
            }
            
            .btn-back{
                display:inline-block;
                margin-bottom:10px;
            }
            
        </style>  
        
    </head>
    
    <body>
        <div class="content-wrapper">
            <div class="content">
                <h1>Распарсеная страница <a href="<?=$arguments['url']?>"><?=$arguments['url']?></a></h1>
                
                <a href="#" class="btn-back" onclick="history.back()">
                    Назад
                </a>
                <?php if(!empty($arguments['result'])) : ?>
                    <table class="result-table">
                        <thead>
                            <tr>
                                <th>Название тега</th>
                                <th>Кол-во вхождений на странице</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($arguments['result'] as $key => $value) : ?>
                            <tr>
                                <td><?=$value['name']?></td>
                                <td><?=$value['count']?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>    
                    </table>
                <?php else : ?>
                    <div>На данной странице теги не обнаружены. Возможно это ошибка.</div>
                <?php endif;?>
            </div>
        </div>
    </body>
    
</html>