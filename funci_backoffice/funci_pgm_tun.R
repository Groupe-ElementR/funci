source("/mnt/data/depot/funci/funci_backoffice/funci_pgm.R")

# input and output folders
input <- "/mnt/data/depot/funci/funci_backoffice/input_tun"
output <- "/mnt/data/depot/funci/funci_backoffice/resources_tun"

createFolders(output = output)

myspdf <- importData(input = input)

mydfmetadata <- importMetaData(input = input)

mymat <- CreateDistMatrix(knownpts = myspdf, unknownpts = myspdf,
                          longlat = FALSE, bypassctrl = FALSE)

createGraph(output = output, myspdf = myspdf)

exportNomenclatureAndMap(output = output, myspdf = myspdf)

computeVal(indParams = mydfmetadata, myspdf = myspdf, mymat = mymat,
           dmode = "AsTheCrowFlies",
           aParams = c(0.005, 0.01, 0.05),
           pParams =  c(0,10000,20000,50000),
           seqSpans = c(0, seq(10000, 200000, 10000)))

x1 <- list(dmode = "AsTheCrowFlies", 
           label = "Euclidean Distance",
           pParams =  c(0,10000,20000,50000), 
           order = 1,
           units = "meters")

createParams(output = output, mydfmetadata = mydfmetadata,
             aParams = c(0.005, 0.01, 0.05),
             matlist = list(x1))

