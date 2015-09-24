source("/mnt/data/depot/funci/funci_backoffice/funci_pgm.R")

# input and output folders
input <- "/mnt/data/depot/funci/funci_backoffice/input_idf"
output <- "/mnt/data/depot/funci/funci_backoffice/resources_idf"

createFolders(output = output)

myspdf <- importData(input = input)

mydfmetadata <- importMetaData(input = input)

carmat <- importMatrix(matrixname = "matmin.csv", input = input,
                       myspdf = myspdf)

mymat <- CreateDistMatrix(knownpts = myspdf, unknownpts = myspdf,
                          longlat = FALSE, bypassctrl = FALSE)

createGraph(output = output, myspdf = myspdf)

exportNomenclatureAndMap(output = output, myspdf = myspdf)

computeVal(indParams = mydfmetadata, myspdf = myspdf, mymat = mymat,
           dmode = "AsTheCrowFlies",
           aParams = c(0.005, 0.01, 0.05),
           pParams =  c(0,2500,5000,7500,10000),
           seqSpans = c(0, seq(2500, 50000, 2500)))
computeVal(indParams = mydfmetadata, myspdf = myspdf,
           mymat = carmat,
           dmode = "AsTheCowRolls",
           aParams = c(0.005, 0.01, 0.05),
           pParams =  c(0,5,10,15,20),
           seqSpans = c(0, seq(5, 90, 5)))

x1 <- list(dmode = "AsTheCrowFlies", label = "Euclidean Distance",
           pParams =  c(0,2500,5000,7500,10000), order = 1,
           units = "meters")
x2 <- list(dmode = "AsTheCowRolls", label = "Car Time",
           pParams =  c(0,5,10,15,20), order = 2,
           units = "minutes")

createParams(output = output, mydfmetadata = mydfmetadata,
             aParams = c(0.005, 0.01, 0.05),
             matlist = list(x1,x2))