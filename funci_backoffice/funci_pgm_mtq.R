source("/mnt/data/depot/funci/funci_backoffice/funci_pgm.R")

# input and output folders
input <- "/mnt/data/depot/funci/funci_backoffice/input_mtq"
output <- "/mnt/data/depot/funci/funci_backoffice/resources_mtq"
createFolders(output = output)

myspdf <- importData(input = input)

mydfmetadata <- importMetaData(input = input)

mymat <- CreateDistMatrix(knownpts = myspdf, unknownpts = myspdf,
                          longlat = FALSE, bypassctrl = FALSE)

createGraph(output = output, myspdf = myspdf)

exportNomenclatureAndMap(output = output, myspdf = myspdf)

computeVal(indParams = mydfmetadata, myspdf = myspdf, mymat = mymat,
           dmode = "AsTheCrowFlies",
           aParams = c(0.02, 0.1, 0.5),
           pParams =  c(0,2000,5000,10000),
           seqSpans = c(0, seq(1000, 50000, 1000)))

x1 <- list(dmode = "AsTheCrowFlies", label = "Euclidean Distance",
           pParams =  c(0,2000,5000,10000), order = 1,
           units = "meters")


createParams(output = output, mydfmetadata = mydfmetadata,
             aParams = c(0.02, 0.1, 0.5),
             matlist = list(x1))
